<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuestionFieldsToSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function($table) {
            $table->string('idd_type')->default('private');
            $table->string('idd_email')->nullable();
            $table->string('idd_first_name')->nullable();
            $table->string('idd_last_name')->nullable();
            $table->string('idd_tax_code')->nullable();
            $table->string('idd_birthday')->nullable();

            $table->boolean('idd_private_life')->default(false);
            $table->boolean('idd_professional_life')->default(false);

            $table->boolean('idd_insurance_needs_professional_activity')->default(false);
            $table->boolean('idd_insurance_needs_employee_manager_life')->default(false);
            $table->boolean('idd_insurance_needs_employee_manager_retirement')->default(false);
            $table->boolean('idd_insurance_needs_company_assets')->default(false);
            $table->boolean('idd_insurance_needs_business_credit')->default(false);
            $table->boolean('idd_insurance_needs_vehicle')->default(false);
            $table->boolean('idd_insurance_needs_injuries_illness')->default(false);
            $table->boolean('idd_insurance_needs_home_family')->default(false);
            $table->boolean('idd_insurance_needs_family_members')->default(false);
            $table->boolean('idd_insurance_needs_pension')->default(false);
            $table->boolean('idd_insurance_needs_annuity')->default(false);
            $table->boolean('idd_insurance_needs_heirs_income')->default(false);
            $table->boolean('idd_insurance_needs_investing_saving')->default(false);

            $table->string('idd_talking_business_profession')->nullable();

            $table->boolean('idd_business_protect_danni_to_me')->default(false);
            $table->boolean('idd_business_protect_damage_others')->default(false);
            $table->boolean('idd_business_protect_legal_disputes')->default(false);
            $table->boolean('idd_business_protect_activity_interruption')->default(false);

            $table->boolean('idd_accident_protect_disease')->default(false);
            $table->boolean('idd_accident_protect_hospitalization')->default(false);
            $table->boolean('idd_accident_protect_accident')->default(false);
            $table->boolean('idd_accident_protect_traveling')->default(false);

            $table->boolean('idd_home_family_protect_family')->default(false);
            $table->boolean('idd_home_family_protect_house')->default(false);
            $table->boolean('idd_home_family_protect_legal_dispute')->default(false);

            $table->boolean('idd_paid_up_condition_after_expiration')->default(false);

            $table->boolean('idd_risk_tolerance_media_sr13_sr14')->default(false);

            $table->boolean('idd_insurance_knowledge_level_base')->default(false);

            $table->string('idd_subscription_type')->default('annual');

            $table->string('idd_business_last_year_turnover')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function($table) {
            $table->string('idd_type');
            $table->string('idd_email');
            $table->string('idd_first_name');
            $table->string('idd_last_name');
            $table->string('idd_tax_code');
            $table->string('idd_birthday');

            $table->boolean('idd_private_life');
            $table->boolean('idd_professional_life');

            $table->boolean('idd_insurance_needs_professional_activity');
            $table->boolean('idd_insurance_needs_employee_manager_life');
            $table->boolean('idd_insurance_needs_employee_manager_retirement');
            $table->boolean('idd_insurance_needs_company_assets');
            $table->boolean('idd_insurance_needs_business_credit');
            $table->boolean('idd_insurance_needs_vehicle');
            $table->boolean('idd_insurance_needs_injuries_illness');
            $table->boolean('idd_insurance_needs_home_family');
            $table->boolean('idd_insurance_needs_family_members');
            $table->boolean('idd_insurance_needs_pension');
            $table->boolean('idd_insurance_needs_annuity');
            $table->boolean('idd_insurance_needs_heirs_income');
            $table->boolean('idd_insurance_needs_investing_saving');

            $table->string('idd_talking_business_profession');

            $table->boolean('idd_business_protect_danni_to_me');
            $table->boolean('idd_business_protect_damage_others');
            $table->boolean('idd_business_protect_legal_disputes');
            $table->boolean('idd_business_protect_activity_interruption');

            $table->boolean('idd_accident_protect_disease');
            $table->boolean('idd_accident_protect_hospitalization');
            $table->boolean('idd_accident_protect_accident');
            $table->boolean('idd_accident_protect_traveling');

            $table->boolean('idd_home_family_protect_family');
            $table->boolean('idd_home_family_protect_house');
            $table->boolean('idd_home_family_protect_legal_dispute');

            $table->boolean('idd_paid_up_condition_after_expiration');

            $table->boolean('idd_risk_tolerance_media_sr13_sr14');

            $table->boolean('idd_insurance_knowledge_level_base');

            $table->string('idd_subscription_type');

            $table->string('idd_business_last_year_turnover');
        });
    }
}
