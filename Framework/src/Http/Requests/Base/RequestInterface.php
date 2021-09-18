<?php

namespace Framework\Http\Requests\Base;

interface RequestInterface
{

    /**
     * @return mixed
     */
    public function server(string $attributeName, $default = null);

    /**
     * @return mixed
     */
    public function get(string $attributeName, $default = null);

    /**
     * @return mixed
     */
    public function post(string $attributeName, $default = null);

    /**
     * Есть ли get
     *
     * @return boolean
     */
    public function isGet(): bool;

    /**
     * Есть ли post
     *
     * @return boolean
     */
    public function isPost(): bool;

    /**
     * Проверяет присутствие в get
     *
     * @param string $attributeName
     * @return boolean
     */
    public function isByGet(string $attributeName): bool;

    /**
     * Проверяет присутствие в post
     *
     * @param string $attributeName
     * @return boolean
     */
    public function isByPost(string $attributeName): bool;

    /**
     * Проверяет присутствие в server
     *
     * @param string $attributeName
     * @return boolean
     */
    public function isByServer(string $attributeName): bool;

    /**
     * @return self
     * @throws RuntimeException
     */
    public static function getInstance();

    /**
     * Возвращает url
     *
     * @return string
     */
    public function getUrlPath(): string;

}