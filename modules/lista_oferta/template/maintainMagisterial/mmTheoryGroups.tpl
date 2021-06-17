<tr><td class="i height">
	<div id="container">
		<div id="classes" class="height">
            <!-- BEGIN add_class -->{class}<!-- END add_class -->
		</div>
		<div id="groups" class="height">
            <!-- BEGIN add_group -->
            <div class="group" data-group="{group_group}">
                <div class="group_content">
                    <h2>Grupo {group_group}</h2>
                    <div class="schedule">
                        <!-- BEGIN need_to_select_more --><span class="error">Selecione mais {more_quantity}</span><!-- END need_to_select_more --><!-- BEGIN need_to_select_less --><span class="error">Selecione menos {less_quantity}</span><!-- END need_to_select_less --><!-- BEGIN add_time --><span data-time="{time_time}" class="time <!-- BEGIN time_selected -->selected<!-- END time_selected -->">{time_time}</span><!-- END add_time -->
                        <!-- BEGIN time_error --><span class="error">ERRO</span><!-- END time_error -->
                    </div>
                    <div class="classes">
                        <div class="title"><div class="title_contend"><label>Turmas</label></div></div>
                        <!-- BEGIN add_group_class -->{group_class}<!-- END add_group_class -->
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <!-- END add_group -->
            <div id="add_group" class="group" data-group="">
                <div class="group_content">
                    <h2>Adicionar Grupo</h2>
                    <div id="image_container">
                        <img src="./css/maintainMagisterial/add.png">
                    </div>
                </div>
            </div>
		</div>
		<div class="clear"></div>
	</div>
</td></tr>