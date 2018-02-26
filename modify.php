<?php
/**
 *
 * @category        module
 * @package         wbs_guestbook
 * @author          Konstantin Polyakov
 * @license         http://www.gnu.org/licenses/gpl.html
 * @platform        WebsiteBaker 2.10.0
 * @requirements    PHP 5.2.2 and higher
 *
 */

if(!defined('WB_PATH')) {
        require_once(dirname(dirname(__FILE__)).'/framework/globalExceptionHandler.php');
        throw new IllegalFileException();
}

include(__DIR__.'/lib.class.guestbook.php');
$clsModGuestbook = new ModGuestbook($page_id, $section_id);

$settings = [];
$r = select_row($clsModGuestbook->tbl_settings, "*", " `section_id`=".process_value($section_id)." AND `page_id`=".process_value($page_id));
if (gettype($r) === 'string') { echo $r; }
else if ($r === null) echo 'Настройки не найдены!';
else $settings = $r->fetchRow();
?>

<form>
    <input type="hidden" name="page_id" value="<? echo $page_id; ?>">
    <input type="hidden" name="section_id" value="<? echo $section_id; ?>">
    <input name="is_active" type="checkbox" <? echo isset($settings['is_active']) && $settings['is_active'] === '1' ? 'checked' : ''; ?>> Активна <br>
    <input name="view_when_set_obj_id" type="checkbox" <? echo isset($settings['view_when_set_obj_id']) && $settings['view_when_set_obj_id'] === '1' ? 'checked' : ''; ?>> Отображать только если установлен get_obj <br>

    <input type="button" value="Сохранить" onclick="sendform(this, 'save_settings', {url:WB_URL+'/modules/wbs_guestbook/api.php'});">
</form>