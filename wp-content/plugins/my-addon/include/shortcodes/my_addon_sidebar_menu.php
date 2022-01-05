<?php
/**
 * @param $args [menuId]
 */
function handleMyAddonSidebarMenu($args){
    if(!isset($args['menuid'])){
        echo "Vui lòng cung cấp menuid";
        return;
    }
    $title = isset($args['title']) ? $args['title'] : null;
    $menuId = $args['menuid'];
    $menuItems = wp_get_nav_menu_items($menuId);
    $result = getSubMenu("0",$menuItems);
    ob_start(); ?>
    <div class="my-addon-sidebar-navigation">
        <?php if($title): ?>
        <strong class="title"><?=$title?></strong>
        <?php endif; ?>
        <?php if($menuItems){ ?>
            <ul>
                <?=getSubMenuHtml($result) ?>
            </ul>
        <?php } ?>
    </div>
    <?php
    $html = ob_get_clean();
    echo $html;
}

function getSubMenu($parentId,$menuItems){
    $subMenus = [];
    foreach ($menuItems as $item){
        if($item->menu_item_parent == $parentId){
            $subMenus[] = [
                "id" => $item->ID,
                "title" =>  $item->title,
                "url" => $item->url,
                "subs" => getSubMenu((string)$item->ID,$menuItems),
            ];
        }
    }
    return $subMenus;
}

function getSubMenuHtml($menuItems){
    ob_start(); ?>
    <?php foreach ($menuItems as $item): ?>
        <?php if(!empty($item['subs'])): ?>
            <li><a href="javascript:void(0);"><?=$item['title']?> <em class="mdi mdi-chevron-down"></em></a>
                <ul><?=getSubMenuHtml($item['subs'])?></ul>
            </li>
        <?php else: ?>
            <li><a href="<?=$item['url']?>"><?=$item['title']?></a></li>
        <?php endif; ?>
    <?php endforeach ?>
    <?php
    $html = ob_get_clean();
    return $html;
}
add_shortcode( 'myaddon_sidebar_menu', 'handleMyAddonSidebarMenu' );