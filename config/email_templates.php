<?php

return [
  "created"=>[
      "organization"=>[
          "subject"=>"Organization Posting on the CCE Service Listings database",
          "body"=>"<div><h4>Hi {{contact.name}},</h4><br>
                        <p>Your request to have your organization, {{organization.name}}, listed on the Binghamton University Center for Civic Engagement (CCE) Service Listings volunteer database has been received. Your submission will be reviewed by CCE staff, and you will be alerted via email when your organization is approved. You should receive confirmation of approval within one week of submitting your request. Your organization will not be visible in the Service Listings until it has been approved.</p>
                        <p>Familiarize yourself with the <a href='https://www.binghamton.edu/cce/community-partners/liability.html'>University’s policy regarding liability</a> and students participating in volunteer/internship activities off campus.</p>
                        <p>Thank you, and we look forward to continued partnership!</p><br>
                        <p>Center for Civic Engagement</p>
                        <p>Binghamton University</p>
                        <p>University Union 137</p>
                        <p>607-777-4287</p>
                        <p>cce@binghamton.edu</p><br>

                        <p>www.binghamton.edu/cce</p>
                        <p>www.facebook.com/ccebinghamton</p>
                        <p>www.instagram.com/ccebinghamton</p>
                    </div>"
      ],
      "listing"=>[
          "subject"=>"Project Listing Posting on the CCE Service Listings database",
          "body"=>"<div><h4>Hi {{contact.name}},</h4>
                    <p>Your request to add a new project listing, {{listing.name}}, to your organization’s profile on the Binghamton University Center for Civic Engagement (CCE) Service Listings volunteer database has been received. Your submission will be reviewed by CCE staff, and you will be alerted via email when your project listing is approved. You should receive confirmation of approval within one week of submitting your request.</p>
                    <p>Thank you,</p>
                    <p>Center for Civic Engagement</p>
                    <p>University Union 137</p>
                    <p>607-777-4287</p>
                    <p>cce@binghamton.edu</p><br>

                    <p>www.binghamton.edu/cce</p>
                    <p>www.facebook.com/ccebinghamton</p>
                    <p>www.instagram.com/ccebinghamton</p>
                </div>"
      ]
  ],
    "updated"=>[
        "organization"=>[
            "subject"=>"Organization Update on the CCE Service Listings database",
             "body"=>"<div><h4>Hi {{contact.name}},</h4>
                        <p>Your request to update your organization information for your {{organization.name}} profile on the Binghamton University Center for Civic Engagement (CCE) Service Listings volunteer database has been received. Your submission will be reviewed by CCE staff and should be approved and live on the Service Listings within one week of submitting your request. Until the updated submission has been approved, your organization will not appear on the Service Listings website.</p>
                        <p>Thank you, </p><br>
                        <p>Center for Civic Engagement</p>
                        <p>Binghamton University</p>
                        <p>University Union 137</p>
                        <p>607-777-4287</p>
                        <p>cce@binghamton.edu</p><br>

                        <p>www.binghamton.edu/cce</p>
                        <p>www.facebook.com/ccebinghamton</p>
                        <p>www.instagram.com/ccebinghamton</p>
                    </div>"
        ],
        "listing"=>[
            "subject"=>"Listing Update on the CCE Service Listings database",
            "body"=>"<div><h4>Hi {{contact.name}},</h4>
                        <p>Your request to update your project listing, {{listing.name}}, on the Binghamton University Center for Civic Engagement (CCE) Service Listings volunteer database has been received. Your submission will be reviewed by CCE staff and should be approved and live on the Service Listings within one week of submitting your request. Until the updated submission has been approved, your listing will not appear on the Service Listings website. </p>
                        <p>Thank you, </p><br>
                        <p>Center for Civic Engagement</p>
                        <p>Binghamton University</p>
                        <p>University Union 137</p>
                        <p>607-777-4287</p>
                        <p>cce@binghamton.edu</p><br>

                        <p>www.binghamton.edu/cce</p>
                        <p>www.facebook.com/ccebinghamton</p>
                        <p>www.instagram.com/ccebinghamton</p>
                    </div>"
        ],
        "password"=>[
            "subject"=>"Your password has been updated!",
            "body"=>"<div><h4>Hi {{contact.name}},</h4>
                        <p>Your password for your {{organization.name}} profile on the Binghamton University Center for Civic Engagement (CCE) Service Listings volunteer database has been reset. </p>
                        <p>If you did not request this reset, contact the CCE immediately.</p>
                        <p>Thank you,</p><br>
                        <p>Center for Civic Engagement</p>
                        <p>Binghamton University</p>
                        <p>University Union 137</p>
                        <p>607-777-4287</p>
                        <p>cce@binghamton.edu</p><br>

                        <p>www.binghamton.edu/cce</p>
                        <p>www.facebook.com/ccebinghamton</p>
                        <p>www.instagram.com/ccebinghamton</p>
                    </div>"
        ]
    ],
    "approved"=>[
        "organization"=>[
            "subject"=>"Your organization has been approved!",
            "body"=>"<div><h4>Hi {{contact.name}},</h4>
                        <p>Your request to have your organization, {{organization.name}}, listed on the Binghamton University Center for Civic Engagement (CCE) Service Listings volunteer database has been approved by CCE staff and is now accessible to all Service Listings users.</p>
                        <ul>
                            <li>To add individual project listings for your organization, log in via the <a href='{{url}}'>Service Listings management portal.</a></li>
                            <li>To remove your organization from our database, email the CCE.</li>
                        </ul>
                        <p>If you have any further questions or issues, feel free to call or email us.</p>
                        <p>Thank you,</p><br>
                        <p>Center for Civic Engagement</p>
                        <p>Binghamton University</p>
                        <p>University Union 137</p>
                        <p>607-777-4287</p>
                        <p>cce@binghamton.edu</p><br>

                        <p>www.binghamton.edu/cce</p>
                        <p>www.facebook.com/ccebinghamton</p>
                        <p>www.instagram.com/ccebinghamton</p>
                    </div>"
        ],
        "listing"=>[
            "subject"=>"Your listing has been approved!",
            "body"=>"<div><h4>Hi {{contact.name}},</h4>
                        <p>Your request to add a new project listing, {{listing.name}}, to your organization’s profile on the Binghamton University Center for Civic Engagement (CCE) Service Listings volunteer database has been approved by CCE staff and is now accessible to all Service Listings users. Students will contact you directly through a contact form to initiate a conversation about their interest.</p>
                        <ul>
                            <li>Once a position has been filled to capacity or is otherwise outdated, please remove the project listing. To edit or delete a project listing or to add more project listings for your organization, log in via the <a href='{{url}}'>Service Listings management portal</a>.</li>
                        </ul>
                        <p>If you have any further questions or issues, feel free to call or email us.</p>
                        <p>Thank you,</p><br>
                        <p>Center for Civic Engagement</p>
                        <p>Binghamton University</p>
                        <p>University Union 137</p>
                        <p>607-777-4287</p>
                        <p>cce@binghamton.edu</p><br>

                        <p>www.binghamton.edu/cce</p>
                        <p>www.facebook.com/ccebinghamton</p>
                        <p>www.instagram.com/ccebinghamton</p>
                    </div>"
        ]
    ],
    "reset"=>[
        "password"=>[
            "subject"=>"Password Reset Request",
            "body"=>"<div><h4>Hi {{name}},</h4>
                        <p>You recently requested to reset your password for your {{org_name}} profile on the Binghamton University Center for Civic Engagement (CCE) Service Listings volunteer database.</p>
                        <p>To reset your password, click this link: <a href='{{reset_link}}'>Reset Password</a>.</p>
                        <p>Note that this link is only valid for ten minutes. If more than ten minutes has passed since your request, you’ll need to <a href='{{manage_url}}'>submit another request</a>.</p>
                        <p>If you have any further questions or issues, feel free to call or email us.</p>
                        <p>Thank you,</p><br>

                        <p>Center for Civic Engagement</p>
                        <p>Binghamton University</p>
                        <p>University Union 137</p>
                        <p>607-777-4287</p>
                        <p>cce@binghamton.edu</p><br>

                        <p>www.binghamton.edu/cce</p>
                        <p>www.facebook.com/ccebinghamton</p>
                        <p>www.instagram.com/ccebinghamton</p>
                    </div>"
        ]
    ],
    "default"=>[
        "subject"=>"CCE Default",
        "body"=>"<div><p>This is the default email. Please use the correct configuration!</p><br><br>
                 --
                 <br><br>
                 <p>ITS Innovation Team</p>
                 <br><br>
                </div>"
    ]

];
