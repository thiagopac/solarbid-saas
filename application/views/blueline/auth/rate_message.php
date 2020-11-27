<?php $attributes = ['class' => 'form-signin box-shadow', 'role' => 'form', 'id' => 'rate']; ?>

<?= form_open($form_action, $attributes) ?>

<div class="logo">
    <img src="<?= base_url() ?><?= $core_settings->solarbid_logo; ?>"  alt="<?= $core_settings->company; ?>">
</div>
<?php if ($this->session->flashdata('message')) : ?>
    <? $exp = explode(':', $this->session->flashdata('message')); ?>
    <div class="alert alert-<?= $exp[0] ?>">
        <?= $exp[1] ?>
    </div>
<?php else: ?>
<?php header('Location:../login') ?>
<?php endif; ?>

<?= form_close() ?>
