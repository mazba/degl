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
        return !in_array($schema->columnType($field), ['binary', 'text']);
    })
    ->take(7);
%>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href="<?= $this->Url->build(('/Dashboard'), true); ?>">Dashboard</a></li>
        <li class="active"><%= $pluralHumanName %></li>
    </ul>
</div>
<div class="tabbable page-tabs">
    <ul class="nav nav-tabs">
        <li class="active"><?= $this->Html->link(__('List of <%= $pluralHumanName %>'), ['action' => 'index']) ?></li>
        <?php
        if ($user_roles['add'] == 1)
        {
            ?>
            <li><?= $this->Html->link(__('New <%= $singularHumanName %>'), ['action' => 'add']) ?></li>
        <?php
        }
        ?>

    </ul>
</div>

<div class="<%= $pluralVar %> index panel panel-default">
    <div class="panel-heading"><h6 class="panel-title"><i class="icon-table"></i> List of <%= $pluralHumanName %></h6>
    </div>
    <div class="datatable">
        <table class="table">
            <thead>
            <tr>
                <% foreach ($fields as $field): %>
                    <% if (in_array($field, ['created_by', 'created_date', 'updated_by', 'updated_date']))
                    {
                        continue;
                    }
                    elseif (in_array($field, ['name_en']))
                    {
                        %>
                        <th><?= __('NAME_EN') ?></th>
                        <%
                        continue;
                    }
                    elseif (in_array($field, ['name_bn']))
                    {
                        %>
                        <th><?= __('NAME_BN') ?></th>
                        <%
                        continue;
                    }
                    else
                    {

                        %>
                        <th><?= __('<%= $field %>') ?></th>
                    <% } %>
                <% endforeach; %>
                <?php
                if (($user_roles['view'] == 1) || ($user_roles['edit'] == 1) || ($user_roles['delete'] == 1))
                {
                    ?>
                    <th class="actions"><?= __('Actions') ?></th>
                <?php
                }
                ?>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($<%= $pluralVar %> as $<%= $singularVar %>)
            {
            ?>
            <tr>
                <%        foreach ($fields as $field)
                {

                    if (in_array($field, ['created_by', 'created_date', 'updated_by', 'updated_date']))
                    {
                        continue;
                    }
                    $isKey = false;
                    if (!empty($associations['BelongsTo']))
                    {
                        foreach ($associations['BelongsTo'] as $alias => $details)
                        {
                            if ($field === $details['foreignKey'])
                            {
                                $isKey = true;
                                %>
                                <td><?= $<%= $singularVar %>->has('<%= $details['property'] %>') ?
                                $this->Html->link($<%= $singularVar %>-><%= $details['property'] %>
                                -><%= $details['displayField'] %>, ['controller' => '<%= $details['controller'] %>',
                                'action' => 'view', $<%= $singularVar %>-><%= $details['property'] %>
                                -><%= $details['primaryKey'][0] %>]) : '' ?></td>
                                <%
                                break;
                            }
                        }
                    }
                    if ($isKey !== true)
                    {
                        if (substr($field, -5, 5) == '_date')
                        {
                            %>
                            <td><?= $this->System->display_date($<%= $singularVar %>-><%= $field %>) ?></td>
                        <%
                        }
                        elseif (!in_array($schema->columnType($field), ['integer', 'biginteger', 'decimal', 'float']))
                        {
                            %>
                            <td><?= h($<%= $singularVar %>-><%= $field %>) ?></td>
                        <%
                        }
                        else
                        {
                            %>
                            <td><?= $this->Number->format($<%= $singularVar %>-><%= $field %>) ?></td>
                        <%
                        }
                    }
                }

                $pk = '$' . $singularVar . '->' . $primaryKey[0];
                %>
                <td class="actions">
                    <?php
                    if ($user_roles['view'] == 1)
                    {
                    echo $this->Html->link('<button class="btn btn-primary btn-icon" type="button"><i class="icon-newspaper"></i></button>', ['action' => 'view', <%= $pk %>
                    ,'_full'=>true],['escapeTitle' => false, 'title' => 'Details']);
                    }

                    ?>
                    <?php
                    if ($user_roles['edit'] == 1)
                    {
                    echo $this->Html->link('<button class="btn btn-info btn-icon" type="button"><i class="icon-pencil3"></i></button>', ['action' => 'edit', <%= $pk %>
                    ],['escapeTitle' => false, 'title' => 'edit']);
                    }
                    ?>
                    <?php
                    if ($user_roles['delete'] == 1)
                    {
                    echo $this->Form->postLink('<button class="btn btn-danger btn-icon" type="button"><i class="icon-close"></i></button>', ['action' => 'delete', <%= $pk %>],
                    ['confirm' => __('Are you sure you want to delete # {0}?', <%= $pk %>),'escapeTitle' => false,
                    'title' => 'delete']);
                    }

                    ?>
                </td>
            </tr>

            <?php } ?>
            </tbody>
        </table>
    </div>
</div>