<?php
shell_exec('chmod -R 777 app/cache');
shell_exec('php app/console cache:clear');
shell_exec('php app/console assets:install --symlink');
shell_exec('chmod -R 777 app/cache');
echo "<pre>$output</pre>";
shell_exec('chmod -R 777 app/logs');
echo "<pre>$output</pre>";
?>