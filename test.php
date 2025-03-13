<?php

require __DIR__ . '/vendor/autoload.php';

#dfy('SELECT * FROM users WHERE email = "foo@example.com"');
$x = new class {
    protected int $baz = 20;

    private bool $bar = true;

    public string $foo = 'bar';
}
;

dfy($x);

dfy('SELECT * FROM users WHERE email = "foo@example.com"')->color('red');
