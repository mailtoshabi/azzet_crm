<?php echo '<?php' ?>


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class <?php echo e($class); ?> extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema to create roles table
        Schema::create('<?php echo e($entrust['tables']['roles']); ?>', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Schema to create permissions table
        Schema::create('<?php echo e($entrust['tables']['permissions']); ?>', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
        
        // Schema to create role_users table
        Schema::create('<?php echo e($entrust['tables']['role_user']); ?>', function (Blueprint $table) {
            $table->unsignedBigInteger('<?php echo e($entrust['foreign_keys']['role']); ?>');
            $table->unsignedBigInteger('<?php echo e($entrust['foreign_keys']['user']); ?>');

            $table->foreign('<?php echo e($entrust['foreign_keys']['user']); ?>')->references('id')->on('<?php echo e($entrust['user_table']); ?>')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('<?php echo e($entrust['foreign_keys']['role']); ?>')->references('id')->on('<?php echo e($entrust['tables']['roles']); ?>')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['<?php echo e($entrust['foreign_keys']['user']); ?>', '<?php echo e($entrust['foreign_keys']['role']); ?>']);
        });

        // Schema to create permission_role table
        Schema::create('<?php echo e($entrust['tables']['permission_role']); ?>', function (Blueprint $table) {
            $table->unsignedBigInteger('<?php echo e($entrust['foreign_keys']['permission']); ?>');
            $table->unsignedBigInteger('<?php echo e($entrust['foreign_keys']['role']); ?>');

            $table->foreign('<?php echo e($entrust['foreign_keys']['permission']); ?>')->references('id')->on('<?php echo e($entrust['tables']['permissions']); ?>')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('<?php echo e($entrust['foreign_keys']['role']); ?>')->references('id')->on('<?php echo e($entrust['tables']['roles']); ?>')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['<?php echo e($entrust['foreign_keys']['permission']); ?>', '<?php echo e($entrust['foreign_keys']['role']); ?>']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('<?php echo e($entrust['tables']['permission_role']); ?>');
        Schema::dropIfExists('<?php echo e($entrust['tables']['role_user']); ?>');
        Schema::dropIfExists('<?php echo e($entrust['tables']['permissions']); ?>');
        Schema::dropIfExists('<?php echo e($entrust['tables']['roles']); ?>');
    }
}<?php /**PATH C:\xampp\htdocs\azzet_crm\vendor\shanmuga\laravel-entrust\src\resources\views\migration.blade.php ENDPATH**/ ?>