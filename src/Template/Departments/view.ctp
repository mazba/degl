<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Department'), ['action' => 'edit', $department->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Department'), ['action' => 'delete', $department->id], ['confirm' => __('Are you sure you want to delete # {0}?', $department->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Departments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Department'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Offices'), ['controller' => 'Offices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Office'), ['controller' => 'Offices', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="departments view large-10 medium-9 columns">
    <h2><?= h($department->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Office') ?></h6>
            <p><?= $department->has('office') ? $this->Html->link($department->office->name_en, ['controller' => 'Offices', 'action' => 'view', $department->office->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Name En') ?></h6>
            <p><?= h($department->name_en) ?></p>
            <h6 class="subheader"><?= __('Name Bn') ?></h6>
            <p><?= h($department->name_bn) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($department->id) ?></p>
        </div>
    </div>
</div>
