<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegulationsTest extends TestCase
{
    /**
     * Проверка редиректа на главную страницу
     *
     * @return void
     */
    public function testRedirectIndexPage()
    {
        $response = $this->get('/test');

        $response->assertRedirect(route('regulations.index'));
    }

    /**
     * Проверка ответа от главной страницы
     *
     * @return void
     */
    public function testOpenIndexPage()
    {
        $response = $this->get(route('regulations.index'));

        $response->assertOk();
    }

    /**
     * Проверка ответа от страницы формы
     *
     * @return void
     */
    public function testOpenCreatePage()
    {
        $response = $this->get(route('regulations.create'));

        $response->assertOk();
    }

    /**
     * Проверка загрузки правильного xml
     *
     */
    public function testUploadSuccessfulXml()
    {
        $response = $this->uploadFile('success.xml');

        $response->assertRedirect(route('regulations.create'))->assertSessionHas('success');
    }


    /**
     * Проверка загрузки xml с нарушениями форматирования
     *
     */
    public function testUploadInvalidXml()
    {
        $response = $this->uploadFile('invalid.xml');

        $response->assertRedirect(route('regulations.create'))->assertSessionHasErrors('invalid_xml');
    }


    /**
     * Проверка загрузки не xml
     *
     */
    public function testUploadNotXml()
    {
        $response = $this->uploadFile('not_xml.pdf');

        $response->assertRedirect()->assertSessionHasErrors(['file']);
    }


    /**
     * Проверка загрузки xml с невалидным Email автора
     *
     */
    public function testUploadInvalidValidationEmailXml()
    {
        $response = $this->uploadFile('invalid_validation_email_xml.xml');

        $response->assertRedirect()->assertSessionDoesntHaveErrors(['file', 'invalid_xml', 'unknown_error']);
    }


    /**
     * Проверка загрузки xml с невалидным описанием
     *
     */
    public function testUploadInvalidValidationDescriptionXml()
    {
        $response = $this->uploadFile('invalid_validation_description_xml.xml');

        $response->assertRedirect()->assertSessionDoesntHaveErrors(['file', 'invalid_xml', 'unknown_error']);
    }


    /**
     * Проверка загрузки xml с невалидным GUID
     *
     */
    public function testUploadInvalidValidationGuidXml()
    {
        $response = $this->uploadFile('invalid_validation_guid_xml.xml');

        $response->assertRedirect()->assertSessionDoesntHaveErrors(['file', 'invalid_xml', 'unknown_error']);
    }


    /**
     * Проверка загрузки xml с не активной ссылкой
     *
     */
    public function testUploadInvalidValidationLinkXml()
    {
        $response = $this->uploadFile('invalid_validation_link_xml.xml');

        $response->assertRedirect()->assertSessionDoesntHaveErrors(['file', 'invalid_xml', 'unknown_error']);
    }


    /**
     * Проверка загрузки xml с пустым заголовком
     *
     */
    public function testUploadInvalidValidationTitleXml()
    {
        $response = $this->uploadFile('invalid_validation_title_xml.xml');

        $response->assertRedirect()->assertSessionDoesntHaveErrors(['file', 'invalid_xml', 'unknown_error']);
    }


    /**
     * @param $name
     * @return \Illuminate\Testing\TestResponse
     *
     * Функция отправки файла
     */
    private function uploadFile($name) {
        $file = new UploadedFile(Storage::path("regulations_test/$name"), $name,
            Storage::size("regulations_test/$name"), null,true);
        return $this->post(route('regulations.store'), [
                'file' => $file
            ]);
    }
}
