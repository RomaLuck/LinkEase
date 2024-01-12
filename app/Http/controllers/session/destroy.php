<?php

use Core\Security\Authenticator;

(new Authenticator)->logout();

redirect('/');