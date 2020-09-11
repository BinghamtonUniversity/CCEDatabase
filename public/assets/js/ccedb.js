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
                                    "label": "Please Select"
                                },
                                {
                                    "label": "Internship"
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
                                    "label": "Abuse/Violence Counseling and/or Prevention",
                                    "value": "Abuse/Violence Counseling and/or Prevention"
                                },
                                {
                                    "label": "Animal Care",
                                    "value": "Animal Care"
                                },
                                {
                                    "label": "Arts/Humanities/Culture",
                                    "value": "Arts/Humanities/Culture"
                                },
                                {
                                    "label": "Business/Management/Entrepreneurship",
                                    "value": "Business/Management/Entrepreneurship"
                                },
                                {
                                    "label": "Crisis Intervention",
                                    "value": "Crisis Intervention"
                                },
                                {
                                    "label": "Disability Support",
                                    "value": "Disability Support"
                                },
                                {
                                    "label": "Education",
                                    "value": "Education"
                                },
                                {
                                    "label": "Elder Services",
                                    "value": "Elder Services"
                                },
                                {
                                    "label": "Environmental",
                                    "value": "Environmental"
                                },
                                {
                                    "label": "Food and Nutrition",
                                    "value": "Food and Nutrition"
                                },
                                {
                                    "label": "Health",
                                    "value": "Health"
                                },
                                {
                                    "label": "Homeless and/or Housing",
                                    "value": "Homeless and/or Housing"
                                },
                                {
                                    "label": "Human Rights",
                                    "value": "Human Rights"
                                },
                                {
                                    "label": "Human Services",
                                    "value": "Human Services"
                                },
                                {
                                    "label": "Immigration Services/Refugee Resettlement",
                                    "value": "Immigration Services/Refugee Resettlement"
                                },
                                {
                                    "label": "Interpretation/Translation Services",
                                    "value": "Interpretation/Translation Services"
                                },
                                {
                                    "label": "Journalism/Media",
                                    "value": "Journalism/Media"
                                },
                                {
                                    "label": "Politics/Policy/Government",
                                    "value": "Politics/Policy/Government"
                                },
                                {
                                    "label": "Social Work/Counseling/Therapy",
                                    "value": "Social Work/Counseling/Therapy"
                                },
                                {
                                    "label": "Sports and Recreation",
                                    "value": "Sports and Recreation"
                                },
                                {
                                    "label": "Student Groups",
                                    "value": "Student Groups"
                                },
                                {
                                    "label": "Technology",
                                    "value": "Technology"
                                },
                                {
                                    "label": "Volunteerism",
                                    "value": "Volunteerism"
                                },
                                {
                                    "label": "Youth",
                                    "value": "Youth"
                                }
                            ]
                        }
                    ]
                }
            ]
        }
    ]
}
