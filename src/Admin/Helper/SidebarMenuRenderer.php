<?php

namespace Xsanisty\Admin\Helper;

use SilexStarter\Contracts\MenuRendererInterface;
use SilexStarter\Menu\MenuContainer;

class SidebarMenuRenderer implements MenuRendererInterface
{
    protected $menu;

    public function render(MenuContainer $menu)
    {
        return $this->generateHtml($menu);
    }

    protected function generateHtml(MenuContainer $menu)
    {
        $format = '<li class="%s" id="%s"><a href="%s" title="%s">%s  %s</a> %s </li>';
        $html   = ($menu->getLevel() == 0) ?
                '<ul class="sidebar"><li class="sidebar-main" id="toggle">
                    <a href="javascript:void(0)">
                        Dashboard
                        <span class="menu-icon glyphicon glyphicon-transfer"></span>
                    </a>
                </li>' : '';

        foreach ($menu->getItems() as $item) {
            if ($item->hasChildren()) {
                $html .= '<li class="sidebar-title"><span>'.$item->getAttribute('label').'</span></li>';
                $html .= $this->generateHtml($item->getChildContainer());
            } else {
                $html .= sprintf(
                    $format,
                    $item->getAttribute('class'). ' sidebar-list '.($item->isActive() ? 'active' : ''),
                    $item->getAttribute('id'),
                    Url::to($item->getAttribute('url')),
                    $item->getAttribute('title'),
                    $item->getAttribute('label'),
                    ($item->getAttribute('icon')) ? '<i class="menu-icon fa fa-fw fa-'.$item->getAttribute('icon').'"></i>' : '',
                    $this->generateHtml($item->getChildContainer())
                );
            }
        }
        $html .= ($menu->getLevel() == 0) ? '</ul>' : '';

        return $html;
    }
}
