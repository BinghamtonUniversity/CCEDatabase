<?php

return [
    // Listing
    'listing' =>
    [
        [
            "name"=> "key",
            "type"=> "hidden"
        ],
        [
            "name"=> "org_code",
            "type"=> "hidden"
        ],
        [
            "type"=> "fieldset",
            "label"=> "Project Information",
            "name"=> "project_information",
            "fields"=> [
                [
                    "type"=> "select",
                    "label"=> "Project Type",
                    "name"=> "type",
                    "multiple"=> false,
                    "required"=> true,
                    "options"=> [
                        [
                            "label"=> "",
                            "type"=> "optgroup",
                            "options"=> [
                                [
                                    "label"=> "Short Term (Lasting Less that a Week)",
                                    "value"=> "short"
                                ],
                                [
                                    "label"=> "Long Term (Lasting More than a Week, or periodically over a long period)",
                                    "value"=> "long"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "label"=> "Title of Project Listing",
                    "name"=> "title",
                    "required"=> true,
                    "type"=> "text"
                ],
                [
                    "label"=> "Location of Project (Valid Address)",
                    "name"=> "location",
                    "required"=> true,
                    "type"=> "text"
                ],
                [
                    "label"=> "Location of Project (Continued)",
                    "name"=> "location2",
                    "required"=> true,
                    "type"=> "text"
                ],
                [
                    "type"=> "select",
                    "label"=> "Category",
                    "name"=> "category",
                    "help"=> "Hold CTRL or command to select multiple.",
                    "multiple"=> true,
                    "required"=> true,
                    "options"=> [
                        [
                            "label"=> "",
                            "type"=> "optgroup",
                            "options"=> [
                                [
                                    "label"=> "Internship",
                                    "value"=> "Internship"
                                ],
                                [
                                    "label"=> "Research",
                                    "value"=> "Research"
                                ],
                                [
                                    "label"=> "Service",
                                    "value"=> "Service"
                                ],
                                [
                                    "label"=> "Group Project",
                                    "value"=> "Group Project"
                                ],
                                [
                                    "label"=> "Academic Service Learning Class",
                                    "value"=> "Academic Service Learning Class"
                                ],
                                [
                                    "label"=> "Other",
                                    "value"=> "Other"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "name"=> "ongoing",
                    "type"=> "checkbox",
                    "label"=> "Ongoing",
                    "options"=> [
                        [
                            "label"=> "No",
                            "value"=> 0
                        ],
                        [
                            "label"=> "Yes",
                            "value"=> 1
                        ],
                    ]
                ],
                [
                    "type"=> "date",
                    "label"=> "Project Start Date",
                    "name"=> "start_date",
                    "columns"=> 6,
                    "show"=> [
                        [
                            "op"=> "and",
                            "conditions"=> [
                                [
                                    "type"=> "matches",
                                    "name"=> "ongoing",
                                    "value"=> 0
                                ]
                            ]
                        ]
                    ],
                    "format"=> [
                                "input"=> "MM/DD/YYYY"
                            ],
                    "required"=> true
                ],
                [
                    "type"=> "date",
                    "label"=> "Project End Date",
                    "name"=> "end_date",
                    "columns"=> 6,
                    "show"=> [
                        [
                            "op"=> "and",
                            "conditions"=> [
                                [
                                    "type"=> "matches",
                                    "name"=> "ongoing",
                                    "value"=> 0
                                ]
                            ]
                        ]
                    ],
                    "format"=> [
                        "input"=> "MM/DD/YYYY"
                    ],
                    "required"=> true
                ],
                [
                    "type"=> "radio",
                    "label"=> "Project Field(s) of Work (Check all that apply)",
                    "name"=> "fields",
                    "help"=> "Hold CTRL or command to select multiple.",
                    "multiple"=> true,
                    "options"=> config('app.categories'),
                    "required"=>true
                ],
                [
                    "label"=> "Please Specify",
                    "name"=> "other_field",
                    "show"=> false,
                    "required"=> "show",
                    "type"=> "text"
                ],
                [
                    "type"=> "select",
                    "label"=> "Paid?",
                    "name"=> "paid",
                    "multiple"=> false,
                    "columns"=> 6,
                    "required"=> true,
                    "options"=> [
                        [
                            "label"=> "",
                            "type"=> "optgroup",
                            "options"=> [
                                [
                                    "label"=> "YES",
                                    "value"=> "YES"
                                ],
                                [
                                    "label"=> "NO",
                                    "value"=> "NO"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "label"=> "Paid Amount",
                    "name"=> "paid_amount",
                    "columns"=> 6,
                    "show"=> [
                        [
                            "op"=> "and",
                            "conditions"=> [
                                [
                                    "type"=> "matches",
                                    "name"=> "paid",
                                    "value"=> [
                                        "YES"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "required"=> true,
                    "type"=> "text"
                ],
                [
                    "type"=> "select",
                    "label"=> "Total Estimated Hours",
                    "name"=> "hours",
                    "multiple"=> false,
                    "forceRow"=> true,
                    "columns"=> 6,
                    "show"=> [
                        [
                            "op"=> "and",
                            "conditions"=> [
                                [
                                    "type"=> "matches",
                                    "name"=> "type",
                                    "value"=> [
                                        "short"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "required"=> "show",
                    "options"=> [
                        [
                            "label"=> "",
                            "type"=> "optgroup",
                            "options"=> [
                                [
                                    "label"=> "1-5",
                                    "value"=> "1-5"
                                ],
                                [
                                    "label"=> "6-10",
                                    "value"=> "6-10"
                                ],
                                [
                                    "label"=> "11-15",
                                    "value"=> "11-15"
                                ],
                                [
                                    "label"=> "16-20",
                                    "value"=> "16-20"
                                ],
                                [
                                    "label"=> "Other",
                                    "value"=> "Other"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "type"=> "select",
                    "label"=> "Weekly Estimated Hours",
                    "name"=> "weekly_hours",
                    "multiple"=> false,
                    "forceRow"=> true,
                    "columns"=> 6,
                    "show"=> [
                        [
                            "op"=> "and",
                            "conditions"=> [
                                [
                                    "type"=> "matches",
                                    "name"=> "type",
                                    "value"=> [
                                        "long"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "required"=> "show",
                    "options"=> [
                        [
                            "label"=> "",
                            "type"=> "optgroup",
                            "options"=> [
                                [
                                    "label"=> "1-5",
                                    "value"=> "1-5"
                                ],
                                [
                                    "label"=> "6-10",
                                    "value"=> "6-10"
                                ],
                                [
                                    "label"=> "11-15",
                                    "value"=> "11-15"
                                ],
                                [
                                    "label"=> "16-20",
                                    "value"=> "16-20"
                                ],
                                [
                                    "label"=> "Other",
                                    "value"=> "Other"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "label"=> "Please Specify",
                    "name"=> "other_hour",
                    "columns"=> 6,
                    "show"=> [
                        [
                            "op"=> "or",
                            "conditions"=> [
                                [
                                    "type"=> "matches",
                                    "name"=> "hours",
                                    "value"=> [
                                        "Other"
                                    ]
                                ],
                                [
                                    "type"=> "matches",
                                    "name"=> "weekly_hours",
                                    "value"=> [
                                        "Other"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "type"=> "text"
                ],
                [
                    "type"=> "select",
                    "label"=> "On A Bus Line?",
                    "name"=> "bus_route",
                    "multiple"=> false,
                    "forceRow"=> true,
                    "columns"=> 6,
                    "required"=> true,
                    "options"=> [
                        [
                            "label"=> "",
                            "type"=> "optgroup",
                            "options"=> [
                                [
                                    "label"=> "YES",
                                    "value"=> "YES"
                                ],
                                [
                                    "label"=> "NO",
                                    "value"=> "NO"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "type"=> "select",
                    "label"=> "Number of People Needed",
                    "name"=> "num_participants",
                    "multiple"=> false,
                    "columns"=> 6,
                    "forceRow"=>true,
                    "required"=> true,
                    "options"=> [
                        [
                            "label"=> "",
                            "type"=> "optgroup",
                            "options"=> [
                                [
                                    "label"=> "1-2",
                                    "value"=> "1-2"
                                ],
                                [
                                    "label"=> "3-5",
                                    "value"=> "3-5"
                                ],
                                [
                                    "label"=> "6-10",
                                    "value"=> "6-10"
                                ],
                                [
                                    "label"=> "11-15",
                                    "value"=> "11-15"
                                ],
                                [
                                    "label"=> "16-20",
                                    "value"=> "16-20"
                                ],
                                [
                                    "label"=> "Other",
                                    "value"=> "Other"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "label"=> "Please Specify",
                    "name"=> "other_people",
                    "columns"=> 6,
                    "show"=> [
                        [
                            "op"=> "and",
                            "conditions"=> [
                                [
                                    "type"=> "matches",
                                    "name"=> "num_participants",
                                    "value"=> [
                                        "Other"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "required"=> "show",
                    "type"=> "text"
                ],
                [
                    "type"=> "radio",
                    "label"=> "Days Preferred (Check All that Apply)",
                    "forceRow"=>true,
                    "name"=> "days",
                    "multiple"=> true,
                    "columns"=> 6,
                    "required"=> true,
                    "options"=> [
                        [
                            "label"=> "",
                            "type"=> "optgroup",
                            "options"=> [
                                [
                                    "label"=> "Sunday",
                                    "value"=> "Sunday"
                                ],
                                [
                                    "label"=> "Monday",
                                    "value"=> "Monday"
                                ],
                                [
                                    "label"=> "Tuesday",
                                    "value"=> "Tuesday"
                                ],
                                [
                                    "label"=> "Wednesday",
                                    "value"=> "Wednesday"
                                ],
                                [
                                    "label"=> "Thursday",
                                    "value"=> "Thursday"
                                ],
                                [
                                    "label"=> "Friday",
                                    "value"=> "Friday"
                                ],
                                [
                                    "label"=> "Saturday",
                                    "value"=> "Saturday"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "type"=> "radio",
                    "label"=> "Time(s) of Day for Participation",
                    "name"=> "time",
                    "multiple"=> true,
                    "columns"=> 6,
                    "required"=> true,
                    "options"=> [
                        [
                            "label"=> "",
                            "type"=> "optgroup",
                            "options"=> [
                                [
                                    "label"=> "Morning",
                                    "value"=> "Morning"
                                ],
                                [
                                    "label"=> "Afternoon",
                                    "value"=> "Afternoon"
                                ],
                                [
                                    "label"=> "Evening",
                                    "value"=> "Evening"
                                ],
                                [
                                    "label"=> "No Preference",
                                    "value"=> "No Preference"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "name"=> "desc",
                    "type"=> "textarea",
                    "label"=> "Description of Project and Tasks",
                    "required"=> true,
                ]
            ]
        ],
        [
            "type"=> "fieldset",
            "label"=> "Contact Info",
            "name"=> "contact_info",
            "showColumn"=>false,
            "fields"=> [
                [
                    "type"=> "fieldset",
                    "label"=> "Primary Contact Information",
                    "name"=> "primary_contact",
                    "fields"=> [
                        [
                            "label"=> "Contact Name",
                            "name"=> "contact_name",
                            "columns"=> 6,
                            "required"=> true,
                            "type"=> "text"
                        ],
                        [
                            "label"=> "Phone Number",
                            "name"=> "contact_phone",
                            "columns"=> 6,
                            "required"=> true,
                            "type"=> "text"
                        ],
                        [
                            "label"=> "Contact Title",
                            "name"=> "contact_title",
                            "columns"=> 6,
                            "required"=> true,
                            "type"=> "text"
                        ],
                        [
                            "type"=> "email",
                            "label"=> "Email Address",
                            "name"=> "contact_email",
                            "columns"=> 6,
                            "required"=> true
                        ],
                        [
                            "label"=> "Mailing Address",
                            "name"=> "contact_address1",
                            "columns"=> 6,
                            "required"=> true,
                            "type"=> "text"
                        ],
                        [
                            "label"=> "Mailing Address (Continued)",
                            "name"=> "contact_address2",
                            "columns"=> 6,
                            "required"=> true,
                            "type"=> "text"
                        ]
                    ]
                ],
                [
                    "type"=> "fieldset",
                    "label"=> "Secondary Contact(Optional)",
                    "name"=> "secondary_contact",
                    "fields"=> [
                        [
                            "label"=> "Contact Name",
                            "name"=> "contact2_name",
                            "columns"=> 6,
                            "type"=> "text"
                        ],
                        [
                            "label"=> "Phone Number",
                            "name"=> "contact2_phone",
                            "columns"=> 6,
                            "type"=> "text"
                        ],
                        [
                            "label"=> "Contact Title",
                            "name"=> "contact2_title",
                            "columns"=> 6,
                            "type"=> "text"
                        ],
                        [
                            "label"=> "Email Address",
                            "name"=> "contact2_email",
                            "columns"=> 6,
                            "type"=> "email"
                        ],
                        [
                            "label"=> "Mailing Address",
                            "name"=> "contact2_address1",
                            "columns"=> 6,
                            "type"=> "text"
                        ],
                        [
                            "label"=> "Mailing Address (Continued)",
                            "name"=> "contact2_address2",
                            "columns"=> 6,
                            "type"=> "text"
                        ]
                    ]
                ]
            ]
        ],
        [
            "type"=> "fieldset",
            "label"=> "Participant Information",
            "name"=> "participant_information",
            "fields"=> [
                [
                    "type"=> "radio",
                    "label"=> "Who would you like to involve? (Check all that apply)",
                    "name"=> "involved_people_type",
                    "multiple"=> true,
                    "required"=> true,
                    "options"=> [
                        [
                            "label"=> "",
                            "type"=> "optgroup",
                            "options"=> [
                                [
                                    "label"=> "Undergraduate Students",
                                    "value"=> "Undergraduate Students"
                                ],
                                [
                                    "label"=> "Staff",
                                    "value"=> "Staff"
                                ],
                                [
                                    "label"=> "Alumni",
                                    "value"=> "Alumni"
                                ],
                                [
                                    "label"=> "Faculty",
                                    "value"=> "Faculty"
                                ],
                                [
                                    "label"=> "Graduate Students",
                                    "value"=> "Graduate Students"
                                ],
                                [
                                    "label"=> "No Preference",
                                    "value"=> "No Preference"
                                ],
                                [
                                    "label"=> "Other",
                                    "value"=> "Other"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "label"=> "Please Specify",
                    "name"=> "involve_other",
                    "show"=> [
                        [
                            "op"=> "and",
                            "conditions"=> [
                                [
                                    "type"=> "contains",
                                    "name"=> "involved_people_type",
                                    "value"=> [
                                        "Other"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "required"=> "show",
                    "type"=> "text"
                ],
                [
                    "type"=> "radio",
                    "label"=> "To which area(s) of Binghamton University does this project/activity relate (so that we may inform them)? (Check all that apply)",
                    "name"=> "university_offices",
                    "multiple"=> true,
                    "required"=> true,
                    "options"=> [
                        [
                            "label"=> "",
                            "type"=> "optgroup",
                            "options"=> [
                                [
                                    "label"=> "Internship Offices",
                                    "value"=> "Internship Offices"
                                ],
                                [
                                    "label"=> "Volunteer Offices",
                                    "value"=> "Volunteer Offices"
                                ],
                                [
                                    "label"=> "Classes",
                                    "value"=> "Classes"
                                ],
                                [
                                    "label"=> "Student Clubs/Organizations",
                                    "value"=> "Student Clubs/Organizations"
                                ],
                                [
                                    "label"=> "Research Centers",
                                    "value"=> "Research Centers"
                                ],
                                [
                                    "label"=> "Academic Departments",
                                    "value"=> "Academic Departments"
                                ],
                                [
                                    "label"=> "Athletic Department",
                                    "value"=> "Athletic Department"
                                ],
                                [
                                    "label"=> "No Preference",
                                    "value"=> "No Preference"
                                ],
                                [
                                    "label"=> "Other University Offices",
                                    "value"=> "Other"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "label"=> "Please Specify",
                    "name"=> "other_university_office",
                    "show"=> [
                        [
                            "op"=> "and",
                            "conditions"=> [
                                [
                                    "type"=> "contains",
                                    "name"=> "university_offices",
                                    "value"=> [
                                        "Other"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "required"=> "show",
                    "type"=> "text"
                ]
            ]
        ],
        [
            "type"=> "fieldset",
            "label"=> "Project Requirements",
            "name"=> "project_requirements",
            "fields"=> [
                [
                    "type"=> "select",
                    "label"=> "Is Training Required?",
                    "name"=> "reqs_training",
                    "multiple"=> false,
                    "columns"=> 6,
                    "required"=> true,
                    "options"=> [
                        [
                            "label"=> "",
                            "type"=> "optgroup",
                            "options"=> [
                                [
                                    "label"=> "NO",
                                    "value"=> "NO"
                                ],
                                [
                                    "label"=> "YES",
                                    "value"=> "YES"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "label"=> "Please Specify",
                    "name"=> "specify_training",
                    "columns"=> 6,
                    "show"=> [
                        [
                            "op"=> "and",
                            "conditions"=> [
                                [
                                    "type"=> "matches",
                                    "name"=> "reqs_training",
                                    "value"=> [
                                        "YES"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "required"=> "show",
                    "type"=> "text"
                ],
                [
                    "type"=> "select",
                    "label"=> "Is Proof of Immunization Required?",
                    "name"=> "reqs_immune",
                    "multiple"=> false,
                    "forceRow"=> true,
                    "columns"=> 6,
                    "required"=> true,
                    "options"=> [
                        [
                            "label"=> "",
                            "type"=> "optgroup",
                            "options"=> [
                                [
                                    "label"=> "NO",
                                    "value"=> "NO"
                                ],
                                [
                                    "label"=> "YES",
                                    "value"=> "YES"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "label"=> "Please Specify",
                    "name"=> "specify_immune",
                    "columns"=> 6,
                    "show"=> [
                        [
                            "op"=> "and",
                            "conditions"=> [
                                [
                                    "type"=> "matches",
                                    "name"=> "reqs_immune",
                                    "value"=> [
                                        "YES"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "required"=> "show",
                    "type"=> "text"
                ],
                [
                    "type"=> "select",
                    "label"=> "Application Required?",
                    "name"=> "reqs_application",
                    "multiple"=> false,
                    "forceRow"=> true,
                    "columns"=> 6,
                    "required"=> true,
                    "options"=> [
                        [
                            "label"=> "",
                            "type"=> "optgroup",
                            "options"=> [
                                [
                                    "label"=> "NO",
                                    "value"=> "NO"
                                ],
                                [
                                    "label"=> "YES",
                                    "value"=> "YES"
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    "label"=> "Please Specify",
                    "name"=> "specify_application",
                    "columns"=> 6,
                    "show"=> [
                        [
                            "op"=> "and",
                            "conditions"=> [
                                [
                                    "type"=> "matches",
                                    "name"=> "reqs_application",
                                    "value"=> [
                                        "YES"
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "required"=> "show",
                    "type"=> "text"
                ],
                [
                    "type"=> "textarea",
                    "label"=> "Other Requirements",
                    "name"=> "reqs_desc"
                ]
            ]
        ],
    ],

    // Organization 
    'organization' =>
    [
        [
            "type"=> "hidden",
            "name"=> "key"
        ],
        [
            "type"=> "hidden",
            "name"=> "org_code"
        ],
        [
            "type"=> "hidden",
            "name"=> "remember_token"
        ],
        [
            "type"=> "fieldset",
            "label"=> "Organization Information",
            "name"=> "organization_information",
            "fields"=> [
                [
                    "type"=> "text",
                    "name"=> "name",
                    "label"=> "Name of Organization"
                ],
                [
                    "type"=> "text",
                    "name"=> "address1",
                    "label"=> "Mailing Address"
                ],
                [
                    "type"=> "text",
                    "name"=> "address2",
                    "label"=> "Mailing Address (Continued)"
                ],
                [
                    "type"=> "url",
                    "name"=> "website",
                    "value"=>"http://",
                    "label"=> "Organization Website"
                ],
                [
                    "type"=> "select",
                    "name"=> "type",
                    "label"=> "Type",
                    "options"=> [
                        [
                            "options"=> [
                                [
                                    "label"=> "Government",
                                    "value"=> "Government"
                                ],
                                [
                                    "label"=> "Non-profit",
                                    "value"=> "Non-profit"
                                ],
                                [
                                    "label"=> "Business/Corporation",
                                    "value"=> "Business/Corporation"
                                ],
                                [
                                    "label"=> "Student Organization",
                                    "value"=> "Student Organization"
                                ],
                                [
                                    "label"=> "Faculty",
                                    "value"=> "Faculty"
                                ],
                                [
                                    "label"=> "Other",
                                    "value"=> "Other"
                                ]
                            ],
                            "type"=> "optgroup",
                            "label"=> ""
                        ]
                    ]
                ],
                [
                    "type"=> "textarea",
                    "name"=> "desc",
                    "label"=> "Organization Description"
                ],
                [
                    "type"=> "radio",
                    "name"=> "fields",
                    "label"=> "Project Field(s) of Work (Check all that apply)",
                    "multiple"=> true,
                    "options"=> [
                        [
                            "options"=> config('app.categories'),
                            "type"=> "optgroup",
                        ]
                    ]
                ]
            ]
        ],
        [
            "type"=> "fieldset",
            "label"=> "Primary Contact",
            "name"=> "primary_contact",
            "fields"=> [
                [
                    "type"=> "text",
                    "name"=> "contact_name",
                    "label"=> "Contact Name"
                ],
                [
                    "type"=> "tel",
                    "name"=> "contact_phone",
                    "label"=> "Phone Number"
                ],
                [
                    "type"=> "text",
                    "name"=> "contact_title",
                    "label"=> "Contact Title"
                ],
                [
                    "type"=> "email",
                    "name"=> "contact_email",
                    "label"=> "Email Address"
                ],
                [
                    "type"=> "text",
                    "name"=> "contact_address1",
                    "label"=> "Mailing Address"
                ],
                [
                    "type"=> "text",
                    "name"=> "contact_address2",
                    "label"=> "Mailing Address (Continued)"
                ]
            ]
        ],
        [
            "type"=> "fieldset",
            "label"=> "Secondary Contact",
            "name"=> "secondary_contact",
            "fields"=> [
                [
                    "type"=> "text",
                    "name"=> "contact2_name",
                    "label"=> "Contact Name"
                ],
                [
                    "type"=> "tel",
                    "name"=> "contact2_phone",
                    "label"=> "Phone Number"
                ],
                [
                    "type"=> "text",
                    "name"=> "contact2_title",
                    "label"=> "Contact Title"
                ],
                [
                    "type"=> "email",
                    "name"=> "contact2_email",
                    "label"=> "Email Address"
                ],
                [
                    "type"=> "text",
                    "name"=> "contact2_address1",
                    "label"=> "Mailing Address"
                ],
                [
                    "type"=> "text",
                    "name"=> "contact2_address2",
                    "label"=> "Mailing Address (Continued)"
                ]
            ]
        ]
    ],

    // Password
    'password' =>
    [
        [
            "type"=> "password",
            "name"=> "passcode",
            "label"=> "Password"
        ],
        [
            "type"=> "password",
            "name"=> "confirm_passcode",
            "label"=> "Confirm Password",
            "validate"=> [
                [
                    "type"=> "matches",
                    "name"=> "passcode",
                    "conditions"=> true
                ]
            ],
        ]
    ],
];