<tr><td class="i height">
	<div id="container">
		<div id="professors" class="height">
			{professor_list}
		</div>
		<div id="classes" class="height">
			<!-- BEGIN add_class_group -->
			<div class="class_group">
				<div class="class_column">
					<!-- BEGIN add_class_0 -->
					<div id="class_{class_0_id}" class="class <!-- BEGIN schedule_shock_block_0 -->scheduleShock <!-- END schedule_shock_block_0 -->{class_0_schedule2}" data-id="{class_0_id}" data-discipline="{class_0_discipline_period}">
						<div class="class_content">
						<h3>{class_0_discipline_name} - {class_0_class}</h3>
						<div class="schedule">{class_0_schedule}</div>
						<div class="container">{class_0_professor_block}</div>
						</div>
					</div>
					<!-- END add_class_0 -->
				</div>
				<div class="class_column">
					<!-- BEGIN add_class_1 -->
					<div id="class_{class_1_id}" class="class <!-- BEGIN schedule_shock_block_1 -->scheduleShock <!-- END schedule_shock_block_1 -->{class_1_schedule2}" data-id="{class_1_id}" data-discipline="{class_1_discipline_period}">
						<div class="class_content">
						<h3>{class_1_discipline_name} - {class_1_class}</h3>
						<div class="schedule">{class_1_schedule}</div>
						<div class="container">{class_1_professor_block}</div>
						</div>
					</div>
					<!-- END add_class_1 -->
				</div>
				<div class="class_column">
					<!-- BEGIN add_class_2 -->
					<div id="class_{class_2_id}" class="class <!-- BEGIN schedule_shock_block_2 -->scheduleShock <!-- END schedule_shock_block_2 -->{class_2_schedule2}" data-id="{class_2_id}" data-discipline="{class_2_discipline_period}">
						<div class="class_content">
						<h3>{class_2_discipline_name} - {class_2_class}</h3>
						<div class="schedule">{class_2_schedule}</div>
						<div class="container">{class_2_professor_block}</div>
						</div>
					</div>
					<!-- END add_class_2 -->
				</div>
				<div class="clear"></div>
			</div>
			<!-- END add_class_group -->
		</div>
		<div class="clear"></div>
	</div>
</td></tr>

<!--
<td id="professors">
	<div id="professors_scroll">
		<div class="professor">Professor 1</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
		<div class="professor">Professor 2</div>
	</div>
</td>
<td>
	<div id="class_scroll">
		<!-- BEGIN add_class -- >
		<div id="class_{class_id}" class="class" data-id="{class_id}">
			<h3>{class_discipline_name} - {class_class}</h3>
			<div>{class_schedule}</div>
			<div class="container"></div>
		</div>
		<!-- END add_class -- >
	</div>
</td>
-->