<?PHP
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarnesTable extends Migration
{
    public function up()
    {
        Schema::create('carnes', function (Blueprint $table) {
            $table->id();
            $table->decimal('valor_total', 15, 2);
            $table->decimal('valor_entrada', 15, 2)->nullable();
            $table->integer('qtd_parcelas');
            $table->date('data_primeiro_vencimento');
            $table->string('periodicidade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carnes');
    }
}
