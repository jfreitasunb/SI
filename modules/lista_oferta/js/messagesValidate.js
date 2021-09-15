/**
 * Created by phelippe on 13/12/16.
 */

$.validator.addMethod(
	"dateBR",
	function(value, element) {
		var check = false;
		var re = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
		if( re.test(value)) {
			var adata = value.split('/');
			var gg = parseInt(adata[0],10);
			var mm = parseInt(adata[1],10);
			var aaaa = parseInt(adata[2],10);
			var xdata = new Date(aaaa,mm-1,gg);
			if ( ( xdata.getFullYear() == aaaa ) && ( xdata.getMonth () == mm - 1 ) && ( xdata.getDate() == gg ) )
				check = true;
			else
				check = false;
		} else
			check = false;
		return this.optional(element) || check;
	},
	"Please enter a valid date."
);

$.validator.addMethod(
    "sum",
    function (value, element, params) {
        var sumOfVals = 0;
        params[1].each(function( index ) {
			sumOfVals = sumOfVals + parseInt($(this).val(), 10);
		});
		if (sumOfVals == params[0]) return true;
        return false;
    },
    jQuery.validator.format("Sum must be {0}")
);

// $.validator.addMethod(
//     "sum",
//     function (value, element, params) {
//         var sumOfVals = 0;
//         var parent = $(element).parent(".parentDiv");
//         $(parent).find("input").each(function () {
//             sumOfVals = sumOfVals + parseInt($(this).val(), 10);
//         });
//         if (sumOfVals == params) return true;
//         return false;
//     },
//     jQuery.validator.format("Sum must be {0}")
// );

jQuery.extend(jQuery.validator.messages, {
	required: "Obrigatório.",
	digits: "Apenas números inteiros.",
	number: "Apenas números, use \".\" para decimal.",
	range: jQuery.validator.format("Apenas valores entre {0} e {1}."),
	min: jQuery.validator.format("Apenas valores maiores ou iguais a {0}."),
	max: jQuery.validator.format("Apenas valores menores ou iguais a {0}."),
	dateBR: "Insira uma data válida.",
	sum: "Soma deve ser {0}"
});

// jQuery.extend(jQuery.validator.messages, {
// 	required: "This field is required.",
// 	remote: "Please fix this field.",
// 	email: "Please enter a valid email address.",
// 	url: "Please enter a valid URL.",
// 	date: "Please enter a valid date.",
// 	dateISO: "Please enter a valid date (ISO).",
// 	number: "Please enter a valid number.",
// 	digits: "Please enter only digits.",
// 	creditcard: "Please enter a valid credit card number.",
// 	equalTo: "Please enter the same value again.",
// 	accept: "Please enter a value with a valid extension.",
// 	maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
// 	minlength: jQuery.validator.format("Please enter at least {0} characters."),
// 	rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
// 	range: jQuery.validator.format("Please enter a value between {0} and {1}."),
// 	max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
// 	min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
// });