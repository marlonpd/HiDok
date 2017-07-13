<?php

return ['constants' => 
        ['account_type',
         'account_type_label',
         'account_type_rev',
         'gender',
         'religion',
         'specialization',
         'appointment_status',
		 'images',
		 'individual_treatment_record_set',
		 'path',
		 'term_type',
		 'individual_treatment_record_type',
        ],
		'term_type' =>[
			'vital_sign'   ,
			'symptom'      ,
			'diagnosis'    ,
			'treatment'    ,
			'laboratory'   		,
			'physical_exam'		, 
			'general_appearance',
			'skin' 				, 
			'heent',
			'neck',
			'chest_and_lungs',
			'cardiovascular_system',
			'abdomen',
			'genito_urinary_system',
			'extremities',
		],
		'path' => [
			'user_photo' => '/images/photo',
			'user_photo_thumb' => '/images/photo/thumb',
		],
		'images' => [
				'default_photo' => '/images/default_avatar_male.jpg',
		],
		'account_type' => [
				'patient'    => 0,
				'doctor'     => 1,
				'hospital'   => 2,
				'laboratory' => 3,
				'pharmacy'   => 4,
		],
		'individual_treatment_record_set' =>[
				0 => 'Chief Complaint',
				1 => 'Vital Signs',
				2 => 'Brief History of Present Illness',
				3 => 'Past Medical History',
				4 => 'PhysicalExam',
				5 => 'Laboratory',
				6 => 'Diagnosis',
				7 => 'Treatment',
		],
		'individual_treatment_record_type' =>[
				'chief_complaint'             => 'Chief Complaint',
				'vital_sign'                  => 'Vital Signs',
				'present_illness_history'     => 'Brief History of Present Illness',
				'past_medical_history'        => 'Past Medical History',
				'physical_exam'               => 'PhysicalExam',
				'laboratory'                  => 'Laboratory',
				'diagnosis'                   => 'Diagnosis',
				'treatment'                   => 'Treatment',
				'other_medical_intervention'  => 'Other Medical Intervention',
				'abdomen'					  => 'Abdomen',
				'cardiovascular_system'		  => 'Cardiovascular System',
				'chest_and_lungs'			  => 'Chest and Lungs',
				'extremities'				  => 'Extremities',
				'general_appearance'		  => 'General Appearance',
				'genito_urinary_system'		  => 'Genito Urinary System',
				'heent'						  => 'Heent',	
				'neck'						  => 'Neck',
				'skin'						  => 'Skin',
				'symptom'					  => 'Symptom',

		],
		'notification_action' =>[
			'request_appointment' => 'Requested for an appointment.',
			'resched_appointment' => 'Rescheduled the appointment.',
			'confirm_appointment' => 'Comfirmed the appointment.',
			'send_feedback'		  => 'Sent you a feedback.',
			'rate'				  => 'Rated you.',
			'create_consultation' => 'Your new medical record has been created.',
		],
		'account_type_label' => [
				'patient'    => 'Patient',
				'doctor'     => 'Doctor',
				'hospital'   => 'Hospital',
				'pharmacy'   => 'Pharmacy',
				'laboratory' => 'Laboratory',
		],
		'account_type_rev' => [
				0 => 'patient',
				1 => 'doctor' ,
				2 => 'hospital',
				3 => 'laboratory',
				4 => 'pharmacy'
		],
		'gender' => [
			0 => 'Male',
			1 => 'Female',
		],
		'religion' => [
			'Roman Catholic',
			'Islam',
			'Budhism',
			'Hinduism',
			'Evangelicals',
			'Iglesia Ni Cristo',
			'Non-Roman Catholic and Protestant',
			'Aglipayan',
			'Seventh-day Adventist',
			'Bible Baptist Church',
			'United Church of Christ in the Philippines',
			'Jehovah\'s Witnesses',
			'Other Protestants',
			'Church of Christ',
			'Jesus is Lord Church',
			'Tribal Religions',
			'United Pentecostal Church (Philippines) Inc.',
			'Other Baptists',
			'Philippine Independent Catholic Church',
			'Unión Espiritista Cristiana de Filipinas, Inc.',
			'Church of Jesus Christ of the Latter Day Saints',
			'Association of Fundamental Baptist Churches in the Philippines',
			'Evangelical Christian Outreach Foundation',
			'None',
			'Convention of the Philippine Baptist Church',
			'Crusaders of the Divine Church of Christ Inc.',
			'Lutheran Church of the Philippines',
			'Iglesia sa Dios Espiritu Santo Inc.',
			'Philippine Benevolent Missionaries Association',
			'Faith Tabernacle Church (Living Rock Ministries)',
			'Others',
		],
		'specialization' => [
			'Allergy and immunology',
			'Adolescent medicine',
			'Anaesthesiology',
			'Pathology',
			'Cardiology',
			'Paediatric cardiology',
			'Cardiothoracic surgery',
			'Child and adolescent psychiatry and psychotherapy',
			'Clinical neurophysiology',
			'Colon and Rectal Surgery',
			'Dermatology-Venereology',
			'Emergency medicine',
			'Endocrinology',
			'Gastroenterology',
			'General practice',
			'Geriatrics',
			'Obstetrics and gynaecology',
			'Health informatics',
			'Hospice and palliative medicine',
			'Infectious disease',
			'Internal medicine',
			'Interventional radiology',
			'Vascular medicine',
			'Microbiology',
			'Nephrology',
			'Neurology',
			'Neurosurgery',
			'Nuclear medicine',
			'Occupational medicine',
			'Ophthalmology',
			'Orthodontics',
			'Orthopaedics',
			'Oral and maxillofacial surgery',
			'Otorhinolaryngology',
			'Paediatrics',
			'Paediatric allergology',
			'Paediatric endocrinology and diabetes',
			'Paediatric gastroenterology, hepatology and nutrition',
			'Paediatric haematology and oncology',
			'Paediatric infectious diseases',
			'Neonatology',
			'Paediatric nephrology',
			'Paediatric respiratory medicine',
			'Paediatric rheumatology',
			'Paediatric surgery',
			'Physical medicine and rehabilitation',
			'Plastic, reconstructive and aesthetic surgery',
			'Podiatric medicine',
			'Pulmonology',
			'Psychiatry',
			'Public Health',
			'Radiology',
			'Sports medicine',
			'Neuroradiology',
			'Radiotherapy',
			'General surgery',
			'Urology',
			'Vascular surgery',
		],
		'appointment_status' => [
			'waiting'        => 0,
			'confirm'        => 1,
			'consult'        => 2,
		],
];

?>