window.contact_form_config = {
	"name": "User Options",
	"autoFocus": true,
	"default": {
		"horizontal": false
	},
    "actions": [
		{
			"type": "save",
			"action": "save",
			"label": "Submit",
			"modifiers": "btn btn-info"
		}
	],
	"horizontal": true,
	"fields": [
		{
			"label": "First Name",
			"name": "first_name",
			"columns": 6,
			"required": true,
			"showColumn": true,
			"type": "text"
		},
		{
			"label": "Last Name",
			"name": "last_name",
			"columns": 6,
			"required": true,
			"showColumn": true,
			"type": "text"
		},
		{
			"label": "Email Address",
			"name": "email",
			"columns": 6,
			"required": true,
			"showColumn": true,
			"type": "email"
		},
		{
			"label": "Phone Number",
			"name": "phone",
			"columns": 6,
			"showColumn": true,
			"type": "phone"
		},
		{
			"label": "Message",
			"name": "message",
			"required": true,
			"showColumn": true,
			"type": "textarea"
		}
	]
}
