<?php
#  Copyright 2003-2015 Opmantek Limited (www.opmantek.com)
#
#  ALL CODE MODIFICATIONS MUST BE SENT TO CODE@OPMANTEK.COM
#
#  This file is part of Open-AudIT.
#
#  Open-AudIT is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as published
#  by the Free Software Foundation, either version 3 of the License, or
#  (at your option) any later version.
#
#  Open-AudIT is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
#
#  You should have received a copy of the GNU Affero General Public License
#  along with Open-AudIT (most likely in a file named LICENSE).
#  If not, see <http://www.gnu.org/licenses/>
#
#  For further information on Open-AudIT or for a license other than AGPL please see
#  www.opmantek.com or email contact@opmantek.com
#
# *****************************************************************************

/**
* @category  View
* @package   Open-AudIT
* @author    Mark Unwin <marku@opmantek.com>
* @copyright 2014 Opmantek
* @license   http://www.gnu.org/licenses/agpl-3.0.html aGPL v3
* @version   2.0.6
* @link      http://www.open-audit.org
 */
$refine_link = $_SERVER["REQUEST_URI"];
if (strpos($refine_link, '?') === false) {
    $refine_link .= '?';
} else if (strrpos($refine_link, '&') !== strlen($refine_link)-1) {
    $refine_link .= '&';
}
$properties = array('description', 'function', 'nmis_group', 'nmis_role', 'omk_uuid');
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?php include('include_collection_panel_header.php'); ?>
    </div>
    <div class="panel-body">
        <?php include('include_collection_panel_body_links.php'); ?>
        <?php if (!empty($this->response->data)) { ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center"><?php echo __('View')?></th>
                        <th><?php echo __('Name (nmis_name)')?></th>
                        <th><?php echo __('Host (ip or fqdn or hostname)')?></th>
                        <th><?php echo __('Notes (description)')?></th>
                        <th><?php echo __('Business Service (function)')?></th>
                        <th><?php echo __('NMIS Group (nmis_group)')?></th>
                        <th><?php echo __('NMIS Role (nmis_role)')?></th>
                        <th><?php echo __('UUID (omk_uuid)')?></th>
                        <th class="text-center">
                            <button type="button" class="btn btn-primary btn-xs nmis_export_button" id="nmis_export_button">Export</button>&nbsp;
                            <input type="checkbox" name="select_all" id="select_all" onclick="select_all_click();"/>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->response->data as $item):
                        ?>
                        <tr>
                            <td class="text-center"><a role="button" class="btn btn-sm btn-success" href="devices/<?php echo intval($item->id); ?>"><?php echo htmlspecialchars($item->id, REPLACE_FLAGS, CHARSET)?></a></td>
                            <td><?php echo htmlspecialchars($item->attributes->nmis_name); ?></td>
                            <?php if (!empty($item->attributes->ip)) { ?>
                            <td><?php echo htmlspecialchars($item->attributes->ip); ?></td>
                            <?php } else if (!empty($item->attributes->fqdn)) { ?>
                            <td><?php echo htmlspecialchars($item->attributes->fqdn); ?></td>
                            <?php } else if (!empty($item->attributes->hostname)) { ?>
                            <td><?php echo htmlspecialchars($item->attributes->hostname); ?></td>
                            <?php } else { ?>
                            <td></td>
                            <?php } ?>
                            <?php foreach ($properties as $property) {
                                echo "            <td><span class=\"small glyphicon glyphicon-filter\" aria-hidden=\"true\" data-html=\"true\" data-toggle=\"popover\" title=\"Refine\" data-content=\"<a href='" . $refine_link . $property . "=!=" . urlencode($item->attributes->$property) . "'>Exclude</a><br /><a href='" . $refine_link . $property . "=" . urlencode($item->attributes->$property) . "'>Include</a><br />\"></span>&nbsp;" . $item->attributes->$property . "</td>\n";
                            } ?>
                            <td class="text-center"><input type='checkbox' id='ids[<?php echo intval($item->id); ?>]' value='<?php echo intval($item->id); ?>' name='ids[<?php echo intval($item->id); ?>]' /></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>