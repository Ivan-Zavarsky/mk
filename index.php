<?php

/*
	task
	1. Напишите функцию подготовки строки, которая заполняет шаблон данными из указанного объекта
	2. Пришлите код целиком, чтобы можно его было проверить
	3. Придерживайтесь code style текущего задания
	4. По необходимости - можете дописать код, методы
	5. Разместите код в гите и пришлите ссылку
*/

/**
 * Класс для работы с API
 *
 * @author        User Name
 * @version        v.1.0 (dd/mm/yyyy)
 */
class Api
{
    public function __construct()
    {

    }


    /**
     * Заполняет строковый шаблон template данными из объекта object
     *
     * @param array $array
     * @param string $template
     * @return        string
     * @version        v.1.0 (dd/mm/yyyy)
     * @author        User Name
     */
    public function get_api_path(array $array, string $template): string
    {
        $result = '';
        $space_replacement = '%20';

        foreach ($array as $key => $value) {
            $array[$key] = preg_replace('/\s/', $space_replacement, $value);
        }

        $template_array = explode('/', $template);
        foreach ($template_array as $key => $value) {
            if (preg_match('/%(\w+)%/', $value, $matches)) {
                $template_array[$key] = $array[$matches[1]];
            }
        }

        $result = implode('/', $template_array);
        /* Здесь ваш код */

        return $result;
    }
}

$user =
    [
        'id' => 20,
        'name' => 'John Dow',
        'role' => 'QA',
        'salary' => 100
    ];

$api_path_templates =
    [
        "/api/items/%id%/%name%",
        "/api/items/%id%/%role%",
        "/api/items/%id%/%salary%"
    ];

$api = new Api();

$api_paths = array_map(function ($api_path_template) use ($api, $user) {
    return $api->get_api_path($user, $api_path_template);
}, $api_path_templates);

echo json_encode($api_paths, JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);

$expected_result = ['/api/items/20/John%20Dow', '/api/items/20/QA', '/api/items/20/100'];