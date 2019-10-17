<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('changeset_id');
            $table->boolean('visible');
            $table->timestamp('timestamp');
            $table->unsignedBigInteger('version');
            $table->unsignedBigInteger('uid');
            $table->string('user');
        });

        Schema::create('relation_tags', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->unsignedBigInteger('relation_id')->nullable(false);
            $table->string('k', 191);
            $table->string('v');

            $table->index('relation_id', 'relation_id');
            $table->unique(['relation_id', 'k'], 'unique_relation_id_k');
        });

        Schema::create('relation_members', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->unsignedBigInteger('relation_id');
            $table->enum('member_type', ['node', 'way', 'relation']);
            $table->unsignedBigInteger('member_id');
            $table->string('member_role', 191);
            $table->unsignedInteger('sequence');

            $table->index('relation_id', 'relation_id');
            $table->index('member_id', 'member_id');
            $table->unique(
                ['relation_id', 'member_type', 'member_id', 'member_role', 'sequence'],
                'relation_members_uniqueness'
            );
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relation_members');
        Schema::dropIfExists('relation_tags');
        Schema::dropIfExists('relations');
    }
}
