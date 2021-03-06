<?php

$user = Auth::user();
$suppliers = [];

foreach ($user->roles as $role) {
    if ($role->enabledAction('supplier.orders'))
        foreach($role->applications(true) as $app)
            if (get_class($app) == 'App\Supplier')
                $suppliers[$app->id] = $app;
}

?>

@include('commons.selectobjfield', [
    'obj' => $order,
    'name' => 'supplier_id',
    'label' => _i('Fornitore'),
    'mandatory' => true,
    'objects' => $suppliers
])

@include('commons.textfield', [
    'obj' => $order,
    'name' => 'comment',
    'label' => _i('Commento')
])

@include('commons.datefield', [
    'obj' => $order,
    'name' => 'start',
    'label' => _i('Data Apertura Prenotazioni'),
    'defaults_now' => true,
    'mandatory' => true
])

@include('commons.datefield', [
    'obj' => $order,
    'name' => 'end',
    'label' => _i('Data Chiusura Prenotazioni'),
    'mandatory' => true,
    'extras' => [
        'data-enforce-after' => '.date[name=start]'
    ]
])

@include('commons.datefield', [
    'obj' => $order,
    'name' => 'shipping',
    'label' => _i('Data Consegna'),
    'extras' => [
        'data-enforce-after' => '.date[name=end]'
    ]
])

@include('commons.orderstatus', ['order' => $order])
