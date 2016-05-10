<%
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Utility\Inflector;

$fields = collection($fields)
    ->filter(function ($field) use ($schema)
    {
        return $schema->columnType($field) !== 'binary';
    });
$pk = "\$$singularVar->{$primaryKey[0]}";
%>
<?php
use Cake\Core\Configure;
?>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('<%= $pluralHumanName %>'), ['action' => 'index']) ?></li>
        <% if (strpos($action, 'add') === false): %>
            <li class="active">Edit <%= $singularHumanName %></li>
        <% else: %>
            <li class="active">New <%= $singularHumanName %></li>
        <% endif; %>

    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of <%= $pluralHumanName %>'), ['action' => 'index']) ?></li>
        <% if (strpos($action, 'add') === false): %>
            <?php
            if ($user_roles['add'] == 1)
            {
                ?>
                <li><?= $this->Html->link(__('New <%= $singularHumanName %>'), ['action' => 'add']) ?></li>
            <?php
            }
            ?>
            <li class="active"><?= $this->Html->link(__('Edit <%= $singularHumanName %>'), ['action' => 'edit', <%= $pk %>
                ]) ?>
            </li>
            <?php
            if ($user_roles['delete'] == 1)
            {
                ?>
                <li><?=
                    $this->Form->postLink(
                        __('Delete <%= $singularHumanName %>'),
                        ['action' => 'delete', $<%= $singularVar %>-><%= $primaryKey[0] %>],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $<%= $singularVar %>
                    -><%= $primaryKey[0] %>)]
                    )
                    ?>
                </li>
            <?php
            }
            ?>
            <?php
            if ($user_roles['view'] == 1)
            {
                ?>
                <li><?= $this->Html->link(__('Details <%= $singularHumanName %>'), ['action' => 'view', <%= $pk %>])
                    ?>
                </li>
            <?php
            }
            ?>

        <% else: %>
            <li class="active"><?= $this->Html->link(__('New <%= $singularHumanName %>'), ['action' => 'add']) ?></li>
        <% endif; %>


    </ul>
</div>


<?= $this->Form->create($<%= $singularVar %>,['class' => 'form-horizontal','role'=>'form']); ?>
<div class="row panel panel-default">

    <div class="panel-heading"><h6 class="panel-title"><i
                class="icon-paragraph-right2"></i><?= __('<%= Inflector::humanize($action) %> <%= $singularHumanName %>') ?>
        </h6></div>
    <div class="panel-body col-sm-6">
        <?php
        <%
        foreach ($fields as $field)
        {
            if (in_array($field, $primaryKey))
            {
                continue;
            }
            if (in_array($field, ['created_by', 'created_date', 'updated_by', 'updated_date']))
            {
                continue;
            }
            if (in_array($field, ['status']))
            {
                %>
                echo $this->Form->input('<%= $field %>', ['options' => Configure::read('status_options')]);
                <%
                continue;
            }
            if (in_array($field, ['name_en']))
            {
                %>
                echo $this->Form->input('name_en',['label'=> __('NAME_EN')]);
                <%
                continue;
            }
            if (in_array($field, ['name_bn']))
            {
                %>
                echo $this->Form->input('name_bn',['label'=> __('NAME_BN')]);
                <%
                continue;
            }
            if (isset($keyFields[$field]))
            {
                $fieldData = $schema->column($field);
                if (!empty($fieldData['null']))
                {
                    %>
                    echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>, 'empty' => true]);
                <%
                }
                else
                {
                    %>
                    echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>]);
                <%
                }
                continue;
            }
            if (!in_array($field, ['created', 'modified', 'updated']))
            {
                $fieldData = $schema->column($field);
                if (($fieldData['type'] === 'date') && (!empty($fieldData['null'])))
                {
                    %>
                    echo $this->Form->input('<%= $field %>', array('empty' => true, 'default' => ''));
                <%
                }
                else
                {
                    %>
                    echo $this->Form->input('<%= $field %>');
                <%
                }
            }
        }
        %>
        ?>
    </div>
    <div class="col-sm-12 form-actions text-right">
        <input type="submit" value="Save" class="btn btn-primary">
    </div>
</div>
<?= $this->Form->end() ?>

