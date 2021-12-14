<?php

namespace App\Http\Controllers;

use App\Models\Regulation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegulationController extends Controller
{
    public function index()
    {
        try {
            $regulations = Regulation::orderByDesc("updated_at")->orderByDesc("project_created")->orderBy("title")->paginate(10);

            return view('regulations.index', compact('regulations'));
        } catch (\Exception $err) {
            return view('regulations.index', ['regulations' => []])->withErrors(['unknown_error' => 'Неизвестная ошибка']);
        }
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * Страница с формой загрузки нормативных документов
     */
    public function create()
    {
        return view('regulations.create');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     *
     * Добавление или обновление нормативных документов из файла
     */
    public function store(Request $request)
    {
        // Валидация входного файла
        $rules = [
            'file' => 'required|file|max:10240|mimes:xml'
        ];

        $validateData = $this->validate($request, $rules);

        // Парсинг XML
        try {
            $xml = simplexml_load_file($validateData['file']);
        } catch (\Exception $err) {
            $xml = false;
        }
        if (!$xml)
            return redirect()->route('regulations.create')->withErrors(['invalid_xml' => 'Не удалось прочесть XML файл']);

        // Преобразование в массив и валидация данных внутри файла
        $xmlArray = json_decode(json_encode($xml), TRUE);

        $validateXmlArr = Validator::make($xmlArray, [
            'channel' => 'required|array',
            'channel.item' => 'required|array',
            'channel.item.*.link' => 'required|active_url',
            'channel.item.*.author' => 'required|email',
            'channel.item.*.title' => 'required|string',
            'channel.item.*.description' => 'required|string|regex:/^ID проекта:\s(.+)\nДата создания:\s(.+)\nРазработчик:\s(.+)\nПроцедура:\s(.+)\nВид:\s(.+)$/iu',
            'channel.item.*.guid' => 'required|integer'
        ])->validate();

        // Преобразование данных перед массовой загрузкой
        $regulations = array_map(function ($item) {
            if (preg_match('/ID проекта:\s(.+)\nДата создания:\s(.+)\nРазработчик:\s(.+)\nПроцедура:\s(.+)\nВид:\s(.+)/iu', $item['description'], $matches)) {
                $item['project_id'] = $matches[1];
                $item['project_created'] = Carbon::createFromLocaleFormat('d M Y', config('faker_locale'), $matches[2])->setTime(0, 0)->toDate();
                $item['project_developer'] = str_replace("\"", "", $matches[3]);
                $item['procedure'] = str_replace("\"", "", $matches[4]);
                $item['kind'] = str_replace("\"", "", $matches[5]);
            }
            unset($item['description']);
            return $item;
        }, $validateXmlArr['channel']['item']);

        // Добавляем или обновляем записи по их guid
        try {
            DB::beginTransaction();

            Regulation::upsert($regulations, ['guid']);

            DB::commit();

            Log::debug('Successful regulations updated');

            return redirect()->route('regulations.create')->with('success', 'Данные успешно загружены!');
        } catch (\Exception $err) {
            DB::rollBack();
            Log::error($err);

            return redirect()->route('regulations.create')->withErrors(['unknown_error' => 'Неизвестная ошибка']);
        }
    }
}
