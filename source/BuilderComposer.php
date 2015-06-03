<?php namespace Apishka\EasyExtend;

use Composer\Script\Event;

/**
 * Builder composer
 *
 * @author Evgeny Reykh <evgeny@reykh.com>
 */

class BuilderComposer
{
    /**
     * Build
     *
     * @param Event $event
     * @access public
     * @return void
     */

    public function build(Event $event)
    {
        // 1. Найти список нужных пакетиков
        // 2. Обыскать пакетики на предмет апишечек
        // 3. Создать файндеры для поиска файликов
        // 4. Создать билдер и запилить кешик
    }
}
