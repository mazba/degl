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

$associations += ['BelongsTo' => [], 'HasOne' => [], 'HasMany' => [], 'BelongsToMany' => []];
$immediateAssociations = $associations['BelongsTo'] + $associations['HasOne'];
$associationFields = collection($fields)
    ->map(function ($field) use ($immediateAssociations)
    {
        foreach ($immediateAssociations as $alias => $details)
        {
            if ($field === $details['foreignKey'])
            {
                return [$field => $details];
            }
        }
    })
    ->filter()
    ->reduce(function ($fields, $value)
    {
        return $fields + $value;
    }, []);

$groupedFields = collection($fields)
    ->filter(function ($field) use ($schema)
    {
        return $schema->columnType($field) !== 'binary';
    })
    ->groupBy(function ($field) use ($schema, $associationFields)
    {
        $type = $schema->columnType($field);
        if (isset($associationFields[$field]))
        {
            return 'string';
        }
        if (in_array($type, ['integer', 'float', 'decimal', 'biginteger']))
        {
            return 'number';
        }
        if (in_array($type, ['date', 'time', 'datetime', 'timestamp']))
        {
            return 'date';
        }
        return in_array($type, ['text', 'boolean']) ? $type : 'string';
    })
    ->toArray();

$groupedFields += ['number' => [], 'string' => [], 'boolean' => [], 'date' => [], 'text' => []];
$pk = "\$$singularVar->{$primaryKey[0]}";
%>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li><?= $this->Html->link(__('<%= $pluralHumanName %>'), ['action' => 'index']) ?> </li>
        <li class="active"><?= __('Detail <%= $singularHumanName %>') ?> </li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li><?= $this->Html->link(__('List of <%= $pluralHumanName %>'), ['action' => 'index']) ?> </li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New <%= $singularHumanName %>'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['edit'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('Edit <%= $singularHumanName %>'), ['action' => 'edit', <%= $pk %>]) ?></li>
        <?php
        }
        ?>
        <?php
        if ($user_roles['delete'] == 1)
        {
            ?>
            <li><?= $this->Form->postLink(__('Delete <%= $singularHumanName %>'), ['action' => 'delete', <%= $pk %>],
                ['confirm' => __('Are you sure you want to delete # {0}?', <%= $pk %>)]) ?>
            </li>
        <?php
        }
        ?>

        <li class="active"><?= $this->Html->link(__('Details <%= $singularHumanName %>'), ['action' => 'view', <%= $pk %>
            ]) ?>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6">
        <% if ($groupedFields['string']) : %>

            <% foreach ($groupedFields['string'] as $field) : %>
                <% if (isset($associationFields[$field])) :
                    $details = $associationFields[$field];
                    %>
                    <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('<%= Inflector::humanize($details['property']) %>') ?></h6>
                        </div>
                        <div class="panel-body"><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ?
                            $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>
                            -><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>',
                            'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>
                            -><%= $details['primaryKey'][0] %>]) : '' ?>
                        </div>
                    </div>
                <% else : %>
                    <div class="panel panel-default">
                        <div class="panel-heading"><h6
                                class="panel-title"><?= __('<%= Inflector::humanize($field) %>') ?></h6></div>
                        <div class="panel-body"><?= h($<%= $singularVar %>-><%= $field %>) ?></div>
                    </div>
                <% endif; %>
            <% endforeach; %>
        <% endif; %>
        <% if ($groupedFields['number']) : %>
            <% foreach ($groupedFields['number'] as $field) : %>
                <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('<%= Inflector::humanize($field) %>') ?></h6></div>
                    <% if (in_array($field, ['created_by', 'created_date', 'updated_by', 'updated_date']))
                    { %>
                        <div class="panel-body"><?= $this->System->display_date_time($<%= $singularVar %>-><%= $field %>)
                            ?>
                        </div>
                    <% }
                     elseif (substr($field, -5, 5) == '_date')
                    { %>
                        <div class="panel-body"><?= $this->System->display_date($<%= $singularVar %>-><%= $field %>)
                            ?>
                        </div>
                    <% }
                    elseif (in_array($field, ['status']))
                    { %>
                        <?php
                        if ($<%= $singularVar %>-><%= $field %>==1)
                        {
                        ?>
                        <div class="panel-body">Active</div>
                    <?php
                    }
                    elseif ($<%= $singularVar %>-><%= $field %>==0)
                    {
                    ?>
                    <div class="panel-body">In-Active</div>
                    <?php
                    }
                    else
                    {
                        ?>
                        <div class="panel-body"><?php echo $<%= $singularVar %>-><%= $field %>;?></div>
                    <?php

                    }
                    ?>
                    <% }else{ %>
                        <div class="panel-body"><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></div>
                    <% } %>
                </div>
            <% endforeach; %>
        <% endif; %>
        <% if ($groupedFields['text']) : %>
            <% foreach ($groupedFields['text'] as $field) : %>
                <div class="panel panel-default">
                    <div class="panel-heading"><h6
                            class="panel-title"><?= __('<%= Inflector::humanize($field) %>') ?></h6></div>
                    <div class="panel-body"><?= $this->Text->autoParagraph(h($<%= $singularVar %>-><%= $field %>)); ?>
                    </div>
                </div>
            <% endforeach; %>
        <% endif; %>
    </div>
</div>