## About this package

This is a simple package built on Symfony workflow Laravel implementation by brexis. It allows you to have simple approval workflows that can be recorded in the database.

Use this to approve things like:
- Transfers
- Data changes
- Or anything that you want to attach an approval to.

It is flexible and agnostic and can be used with any Eloquent model.

## Usage
From your model, implement `Approvable` contract for example
```php
<?php

namespace MyNamespace;

use Illuminate\Database\Eloquent\Model;
use Prodevel\Laravel\Workflow\Traits\ApprovableTrait;
use Prodevel\Laravel\Workflow\Contracts\Approvable;

class DemoModel extends Model implements Approvable {
    use ApprovableTrait;
}
```
### Creating an approval request
```php
<?php

class DemoController {
    
    public function requestApprovalDemo()
    {
        $model = new ModelThatImplementsApprovable;
        $model->requestApproval(Auth::user());
    }
   
}
```

### Approving and rejecting workflow
```php
<?php

class DemoController {
    
    public function requestApprovalDemo()
    {
        $model = ExistingWorkflowThatImplementsApprovable::first();
;
        $model->currentApproval()->approve(Auth::user());
        $model->currentApproval()->reject(Auth::user());
    }
   
}
```

## Security Vulnerabilities

If you discover a security vulnerability within this package, please send an e-mail to Promise via [promise@prodevel.co.uk](mailto:promise@prodevel.co.uk). All security vulnerabilities will be promptly addressed.

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
