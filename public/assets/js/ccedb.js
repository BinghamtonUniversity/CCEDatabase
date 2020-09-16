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

window.search_form = {
    "legend": "Search",
    "name": "search_form",
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
            "label": "General Search",
            "name": "keyword",
            "placeholder": "Project or Org Name / Description",
            "show": [
                {
                    "op": "and",
                    "conditions": [
                        {
                            "type": "matches",
                            "name": "is_advanced",
                            "value": false
                        }
                    ]
                }
            ],
            "required": "show",
            "showColumn": true,
            "type": "text"
        },
        {
            "type": "checkbox",
            "label": "",
            "name": "is_advanced",
            "value": false,
            "showColumn": true,
            "options": [
                {
                    "label": "Advanced Search",
                    "value": false
                },
                {
                    "label": "Advanced Search",
                    "value": true
                }
            ]
        },
        {
            "type": "fieldset",
            "label": "Advanced Search",
            "name": "advanced_search",
            "show": [
                {
                    "op": "and",
                    "conditions": [
                        {
                            "type": "matches",
                            "name": "is_advanced",
                            "value": true
                        }
                    ]
                }
            ],
            "required": "show",
            "fields": [
                {
                    "type": "select",
                    "label": "Category",
                    "name": "category",
                    "multiple": false,
                    "columns": 6,
                    "showColumn": true,
                    "options": [
                        {
                            "label": "",
                            "type": "optgroup",
                            "options": [
                                {
                                    "label": "Please Select",
                                    "value":""
                                },
                                {
                                    "label": "Internship",
                                    "value": "Internship"
                                },
                                {
                                    "label": "Research",
                                    "value": "Research"
                                },
                                {
                                    "label": "Service",
                                    "value": "Service"
                                },
                                {
                                    "label": "Group Project",
                                    "value": "Group Project"
                                }
                            ]
                        }
                    ]
                },
                {
                    "type": "select",
                    "label": "Event Type",
                    "name": "event_type",
                    "multiple": false,
                    "columns": 6,
                    "showColumn": true,
                    "options": [
                        {
                            "label": "",
                            "type": "optgroup",
                            "options": [
                                {
                                    "label":"Please Select",
                                    "value":""
                                },
                                {
                                    "label": "Ongoing",
                                    "value": "ongoing"
                                },
                                {
                                    "label": "Event",
                                    "value": "event"
                                },
                                {
                                    "label": "Annual",
                                    "value": "annual"
                                }
                            ]
                        }
                    ]
                },
                {
                    "type": "radio",
                    "label": "Interest Areas",
                    "name": "interest_areas",
                    "multiple": true,
                    "size":4,
                    "showColumn": true,
                    "required":true,
                    "options": [
                        {
                            "label": "",
                            "type": "optgroup",
                            "options": [
                                {
                                    "label": "Youth",
                                    "value": "Youth"
                                },
                                {
                                    "label": "Seniors/Elder Care",
                                    "value": "Seniors/Elder Care"
                                },
                                {
                                    "label": "Animals",
                                    "value": "Animals"
                                },
                                {
                                    "label": "Hunger/Food",
                                    "value": "Hunger/Food"
                                },
                                {
                                    "label": "Health/Mental Health",
                                    "value": "Health/Mental Health"
                                },
                                {
                                    "label": "Disability",
                                    "value": "Disability"
                                },
                                {
                                    "label": "Environment",
                                    "value": "Environment"
                                },
                                {
                                    "label": "Homelessness/Poverty",
                                    "value": "Homelessness/Poverty"
                                },
                                {
                                    "label": "Civic Participation",
                                    "value": "Civic Participation"
                                },
                                {
                                    "label": "Arts and Culture",
                                    "value": "Arts and Culture"
                                },
                                {
                                    "label": "Events",
                                    "value": "Events"
                                },
                                {
                                    "label": "Virtual/Remote Service",
                                    "value": "Virtual/Remote Service"
                                },
                                {
                                    "label": "Other/General Volunteering",
                                    "value": "Other/General Volunteering"
                                }
                            ]
                        }
                    ]
                }
            ]
        }
    ]
}
