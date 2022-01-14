<h2><?php echo MvcInflector::titleize('Tùy chỉnh'); ?></h2>
<form method="post" action="<?=MvcRouter::admin_url(['controller'=>'api_option','action'=>'index'])?>">
    <div>
        <label class="form">API Key</label>
        <input name="api_key" class="form" type="text" value="<?=$apiKey?>">
    </div>
    <div >
        <label class="form">API URL</label>
        <input name="api_url" class="form" type="text" value="<?=$apiUrl?>">
    </div>
    <div>
        <input class="form" type="submit" name="Cập nhật">
    </div>
</form>