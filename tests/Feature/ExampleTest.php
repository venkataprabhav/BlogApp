<?php

it('redirects unauthenticated users from / to login', function () {
    $this->get('/')->assertRedirect();
});
