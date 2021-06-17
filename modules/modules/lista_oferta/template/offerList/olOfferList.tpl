<tr><td class="i height">
	<div id="container">
		<div id="professors" class="height">
			{professor_list}
		</div>
		<div id="classes" class="height">
			<!-- BEGIN add_class_group -->
			<div class="class_group">
				<!-- BEGIN add_class -->
				<div id="class_{class_id}" class="class <!-- BEGIN schedule_shock_block -->scheduleShock <!-- END schedule_shock_block -->{class_schedule2}" data-id="{class_id}" data-discipline="{class_discipline_period}">
					<div class="class_content">
						<div class="class_content_2">
							<h3>{class_discipline_name} - {class_class}</h3>
							<div class="schedule">{class_schedule}</div>
							<div class="container">{class_professor_block}</div>
						</div>
					</div>
				</div>
				<!-- END add_class -->
			</div>
			<!-- END add_class_group -->
		</div>
		<div class="clear"></div>
	</div>
</td></tr>