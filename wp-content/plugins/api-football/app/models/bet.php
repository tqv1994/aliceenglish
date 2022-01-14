<?php

class Bet extends MvcModel {
    var $table = '{prefix}bets';
    var $order = 'id ASC';
    var $display_field = 'name';
    var $selects = array('id', 'name','bet_id');
}
