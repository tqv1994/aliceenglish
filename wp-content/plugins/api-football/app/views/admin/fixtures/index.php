<h2><?php echo MvcInflector::pluralize_titleize($model->name); ?></h2>

<form id="posts-filter" action="<?php echo MvcRouter::admin_url(); ?>" method="get">

    <p class="search-box">
        <label class="screen-reader-text" for="post-search-input"><?php _e("Search", 'wpmvc'); ?>:</label>
        <input type="hidden" name="page" value="<?php echo MvcRouter::admin_page_param($model->name); ?>" />
        <input type="text" name="q" value="<?php echo empty($params['q']) ? '' : $params['q']; ?>" />
        <input type="submit" value="<?php _e("Search", 'wpmvc'); ?>" class="button" />
    </p>

</form>

<div class="tablenav">

    <div class="tablenav-pages">

        <?php echo paginate_links($pagination); ?>

    </div>

</div>

<div class="clear"></div>

<table class="widefat post fixed striped" cellspacing="0">

    <thead>
        <tr>
            <th>Time</th>
            <th>Home</th>
            <th>Score</th>
            <th>Away</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($objects as $object): ?>
        <?php $data = unserialize($object->data); ?>
        <tr>
            <td><?=$this->datetime->convertDateTime(date('Y-m-d H:i:s',$object->timestamp),'d/m/Y H:i:s',$object->timezone) ?></td>
            <td><?=$data['teams']->home->name?></td>
            <td><?=$data['goals']->home?> - <?=$data['goals']->away?></td>
            <td><?=$data['teams']->away->name?></td>
            <td><?=$object->active == 1 ? 'Live' : ''?></td>
        </tr>
        <?php endforeach ?>
    </tbody>

</table>

<div class="tablenav">

    <div class="tablenav-pages">

        <?php echo paginate_links($pagination); ?>

    </div>

</div>

<br class="clear" />
