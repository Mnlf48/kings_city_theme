<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_homepage',
    'title' => 'Homepage Content',
    'fields' => array(

        array(
            'key' => 'field_tab_home_hero',
            'label' => 'Hero Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_hero_section_img_1',
            'label' => 'Image: Kings City Banner',
            'name' => 'hero_section_img_1',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_hero_section_img_2',
            'label' => 'Image: Kings Place',
            'name' => 'hero_section_img_2',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_hero_section_img_3',
            'label' => 'Image: Kings Bag',
            'name' => 'hero_section_img_3',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_hero_section_txt_4',
            'label' => 'Text: A creative workspace designed ...',
            'name' => 'hero_section_txt_4',
            'type' => 'text',
            'default_value' => 'A creative workspace designed for you.',
        ),

        array(
            'key' => 'field_hero_section_txt_5',
            'label' => 'Text: Our mission is to provide an e...',
            'name' => 'hero_section_txt_5',
            'type' => 'textarea',
            'default_value' => 'Our mission is to provide an environment that allows businesses to connect and grow, and we achieve this
              through continuous research and mindful consideration of every aspect within our spaces.',
        ),

        array(
            'key' => 'field_hero_section_txt_6',
            'label' => 'Text: Welcome to Kings City...',
            'name' => 'hero_section_txt_6',
            'type' => 'text',
            'default_value' => 'Welcome to Kings City',
        ),

        array(
            'key' => 'field_hero_section_txt_7',
            'label' => 'Text: 
                Become a Memb...',
            'name' => 'hero_section_txt_7',
            'type' => 'wysiwyg',
            'default_value' => '<a class="btn" href="apply.html">
                Become a Member
              </a>',
        ),

        array(
            'key' => 'field_tab_home_spaces',
            'label' => 'Space Options',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_section_img_8',
            'label' => 'Image: Coworking Space',
            'name' => 'section_img_8',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_9',
            'label' => 'Image: Private Office Space',
            'name' => 'section_img_9',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_10',
            'label' => 'Image: Enterprise',
            'name' => 'section_img_10',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_11',
            'label' => 'Image: On-Demand',
            'name' => 'section_img_11',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_txt_12',
            'label' => 'Text: Space Options...',
            'name' => 'section_txt_12',
            'type' => 'text',
            'default_value' => 'Space Options',
        ),

        array(
            'key' => 'field_section_txt_13',
            'label' => 'Text: Coworking Space...',
            'name' => 'section_txt_13',
            'type' => 'text',
            'default_value' => 'Coworking Space',
        ),

        array(
            'key' => 'field_section_txt_14',
            'label' => 'Text: Private Office Space...',
            'name' => 'section_txt_14',
            'type' => 'text',
            'default_value' => 'Private Office Space',
        ),

        array(
            'key' => 'field_section_txt_15',
            'label' => 'Text: Enterprise...',
            'name' => 'section_txt_15',
            'type' => 'text',
            'default_value' => 'Enterprise',
        ),

        array(
            'key' => 'field_section_txt_16',
            'label' => 'Text: On-Demand...',
            'name' => 'section_txt_16',
            'type' => 'text',
            'default_value' => 'On-Demand',
        ),

        array(
            'key' => 'field_section_txt_17',
            'label' => 'Text: One pass. All-access. For a fr...',
            'name' => 'section_txt_17',
            'type' => 'textarea',
            'default_value' => 'One pass. All-access. For a freelancer or a large enterprise, we have options to suit
            every need.',
        ),

        array(
            'key' => 'field_section_txt_18',
            'label' => 'Text: 24-7 access to shared workspac...',
            'name' => 'section_txt_18',
            'type' => 'text',
            'default_value' => '24-7 access to shared workspaces and all common areas.',
        ),

        array(
            'key' => 'field_section_txt_19',
            'label' => 'Text: 24-7 access to a private, encl...',
            'name' => 'section_txt_19',
            'type' => 'text',
            'default_value' => '24-7 access to a private, enclosed office space.',
        ),

        array(
            'key' => 'field_section_txt_20',
            'label' => 'Text: A tailored solution to suit sp...',
            'name' => 'section_txt_20',
            'type' => 'text',
            'default_value' => 'A tailored solution to suit specific needs.',
        ),

        array(
            'key' => 'field_section_txt_21',
            'label' => 'Text: Book day passes and facilities...',
            'name' => 'section_txt_21',
            'type' => 'textarea',
            'default_value' => 'Book day passes and facilities across all locations for hybrid teams or
                individuals.',
        ),

        array(
            'key' => 'field_section_txt_22',
            'label' => 'Text: Explore Our Spaces...',
            'name' => 'section_txt_22',
            'type' => 'text',
            'default_value' => 'Explore Our Spaces',
        ),

        array(
            'key' => 'field_section_txt_23',
            'label' => 'Text: 1+...',
            'name' => 'section_txt_23',
            'type' => 'text',
            'default_value' => '1+',
        ),

        array(
            'key' => 'field_section_txt_24',
            'label' => 'Text: 2-50...',
            'name' => 'section_txt_24',
            'type' => 'text',
            'default_value' => '2-50',
        ),

        array(
            'key' => 'field_section_txt_25',
            'label' => 'Text: 20+...',
            'name' => 'section_txt_25',
            'type' => 'text',
            'default_value' => '20+',
        ),

        array(
            'key' => 'field_section_txt_26',
            'label' => 'Text: 1+...',
            'name' => 'section_txt_26',
            'type' => 'text',
            'default_value' => '1+',
        ),

        array(
            'key' => 'field_tab_home_offshoring',
            'label' => 'Offshoring Power',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_section_img_32',
            'label' => 'Image: Offshoring Power - A professio',
            'name' => 'section_img_32',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_txt_33',
            'label' => 'Text: Offshoring Power...',
            'name' => 'section_txt_33',
            'type' => 'text',
            'default_value' => 'Offshoring Power',
        ),

        array(
            'key' => 'field_section_txt_34',
            'label' => 'Text: Unlock the full potential of g...',
            'name' => 'section_txt_34',
            'type' => 'textarea',
            'default_value' => 'Unlock the full potential of global talent. Our offshoring model provides you
              with a dedicated, high-performing team in the Philippines, fully managed and integrated into your business
              for maximum efficiency.',
        ),

        array(
            'key' => 'field_section_txt_35',
            'label' => 'Text: B2B Services...',
            'name' => 'section_txt_35',
            'type' => 'text',
            'default_value' => 'B2B Services',
        ),

        array(
            'key' => 'field_section_txt_36',
            'label' => 'Text: Calculate Staffing Costs...',
            'name' => 'section_txt_36',
            'type' => 'wysiwyg',
            'default_value' => '<a class="btn" href="offshoring.html">Calculate Staffing Costs</a>',
        ),

        array(
            'key' => 'field_tab_home_onepass',
            'label' => 'One Pass',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_section_img_37',
            'label' => 'Image: One Pass. All Access. - Member',
            'name' => 'section_img_37',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_txt_38',
            'label' => 'Text: One Pass. All Access....',
            'name' => 'section_txt_38',
            'type' => 'text',
            'default_value' => 'One Pass. All Access.',
        ),

        array(
            'key' => 'field_section_txt_39',
            'label' => 'Text: Members of Kings Club have rec...',
            'name' => 'section_txt_39',
            'type' => 'textarea',
            'default_value' => 'Members of Kings Club have reciprocal access to our premium facilities. Each member has access to:',
        ),

        array(
            'key' => 'field_section_txt_40',
            'label' => 'Text: Membership...',
            'name' => 'section_txt_40',
            'type' => 'text',
            'default_value' => 'Membership',
        ),

        array(
            'key' => 'field_section_txt_41',
            'label' => 'Text: A dedicated home location 24/7...',
            'name' => 'section_txt_41',
            'type' => 'text',
            'default_value' => 'A dedicated home location 24/7 access',
        ),

        array(
            'key' => 'field_section_txt_42',
            'label' => 'Text: Meeting, conference, training ...',
            'name' => 'section_txt_42',
            'type' => 'text',
            'default_value' => 'Meeting, conference, training and workshop rooms',
        ),

        array(
            'key' => 'field_section_txt_43',
            'label' => 'Text: Event spaces, podcast studios,...',
            'name' => 'section_txt_43',
            'type' => 'text',
            'default_value' => 'Event spaces, podcast studios, and photography studios',
        ),

        array(
            'key' => 'field_section_txt_44',
            'label' => 'Text: Premium Gym access &amp; Kings...',
            'name' => 'section_txt_44',
            'type' => 'text',
            'default_value' => 'Premium Gym access &amp; Kings Club wellness program',
        ),

        array(
            'key' => 'field_section_txt_45',
            'label' => 'Text: Exclusive discounts at our in-...',
            'name' => 'section_txt_45',
            'type' => 'text',
            'default_value' => 'Exclusive discounts at our in-house coffee shops',
        ),

        array(
            'key' => 'field_tab_home_gallery',
            'label' => 'Gallery',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_section_img_46',
            'label' => 'Image: Kings Club Makati',
            'name' => 'section_img_46',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_47',
            'label' => 'Image: Kings Club BGC',
            'name' => 'section_img_47',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_48',
            'label' => 'Image: Kings Club Ortigas',
            'name' => 'section_img_48',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_49',
            'label' => 'Image: Kings Club Alabang',
            'name' => 'section_img_49',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_50',
            'label' => 'Image: Kings Club Quezon City',
            'name' => 'section_img_50',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_51',
            'label' => 'Image: Kings Club Pasay',
            'name' => 'section_img_51',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_52',
            'label' => 'Image: Kings Club Makati',
            'name' => 'section_img_52',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_53',
            'label' => 'Image: Kings Club BGC',
            'name' => 'section_img_53',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_54',
            'label' => 'Image: Kings Club Ortigas',
            'name' => 'section_img_54',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_55',
            'label' => 'Image: Kings Club Alabang',
            'name' => 'section_img_55',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_56',
            'label' => 'Image: Kings Club Quezon City',
            'name' => 'section_img_56',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_57',
            'label' => 'Image: Kings Club Pasay',
            'name' => 'section_img_57',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_tab_home_social',
            'label' => 'Get Social',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_section_img_58',
            'label' => 'Image: Get Social With Us - Kings Clu',
            'name' => 'section_img_58',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_txt_59',
            'label' => 'Text: Get Social With Us...',
            'name' => 'section_txt_59',
            'type' => 'text',
            'default_value' => 'Get Social With Us',
        ),

        array(
            'key' => 'field_section_txt_60',
            'label' => 'Text: Members of Kings Club receive ...',
            'name' => 'section_txt_60',
            'type' => 'textarea',
            'default_value' => 'Members of Kings Club receive exclusive access to our community platform, which allows people to stay
              informed, connected, and engaged with everything happening across our spaces.',
        ),

        array(
            'key' => 'field_section_txt_61',
            'label' => 'Text: Check availability and book me...',
            'name' => 'section_txt_61',
            'type' => 'text',
            'default_value' => 'Check availability and book meeting room and day passes instantly',
        ),

        array(
            'key' => 'field_section_txt_62',
            'label' => 'Text: Find out about events &amp; re...',
            'name' => 'section_txt_62',
            'type' => 'text',
            'default_value' => 'Find out about events &amp; receive reminder notifications',
        ),

        array(
            'key' => 'field_section_txt_63',
            'label' => 'Text: Network and connect with the K...',
            'name' => 'section_txt_63',
            'type' => 'text',
            'default_value' => 'Network and connect with the Kings Club community',
        ),

        array(
            'key' => 'field_section_txt_64',
            'label' => 'Text: Interactive newsfeed...',
            'name' => 'section_txt_64',
            'type' => 'text',
            'default_value' => 'Interactive newsfeed',
        ),

        array(
            'key' => 'field_section_txt_65',
            'label' => 'Text: Direct message other members...',
            'name' => 'section_txt_65',
            'type' => 'text',
            'default_value' => 'Direct message other members',
        ),

        array(
            'key' => 'field_section_txt_66',
            'label' => 'Text: Promote your business and gain...',
            'name' => 'section_txt_66',
            'type' => 'text',
            'default_value' => 'Promote your business and gain opportunities',
        ),

        array(
            'key' => 'field_section_txt_67',
            'label' => 'Text: Member Portal...',
            'name' => 'section_txt_67',
            'type' => 'text',
            'default_value' => 'Member Portal',
        ),

        array(
            'key' => 'field_tab_home_impact',
            'label' => 'Impact',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_section_img_68',
            'label' => 'Image: Impact - Giving Back',
            'name' => 'section_img_68',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_txt_69',
            'label' => 'Text: Impact...',
            'name' => 'section_txt_69',
            'type' => 'text',
            'default_value' => 'Impact',
        ),

        array(
            'key' => 'field_section_txt_70',
            'label' => 'Text: Community and
            sust...',
            'name' => 'section_txt_70',
            'type' => 'textarea',
            'default_value' => 'Community and
            sustainability are central to our mission at Kings City. We contribute to the world beyond our doors by
            supporting Filipino entrepreneurship and local businesses, ensuring our impact extends to the greater
            community and the environment.',
        ),

        array(
            'key' => 'field_section_txt_71',
            'label' => 'Text: We are also
            commit...',
            'name' => 'section_txt_71',
            'type' => 'textarea',
            'default_value' => 'We are also
            committed to maintaining the highest standards of social and environmental performance. Through
            energy-efficient systems, waste reduction, and mindful design, we balance profit and purpose to create a
            more sustainable and inclusive economy.',
        ),

        array(
            'key' => 'field_section_txt_72',
            'label' => 'Text: Giving Back...',
            'name' => 'section_txt_72',
            'type' => 'text',
            'default_value' => 'Giving Back',
        ),

        array(
            'key' => 'field_section_txt_73',
            'label' => 'Text: Badge1...',
            'name' => 'section_txt_73',
            'type' => 'wysiwyg',
            'default_value' => 'Badge<br/>1',
        ),

        array(
            'key' => 'field_section_txt_74',
            'label' => 'Text: Badge2...',
            'name' => 'section_txt_74',
            'type' => 'wysiwyg',
            'default_value' => 'Badge<br/>2',
        ),

        array(
            'key' => 'field_tab_home_updates',
            'label' => 'Latest Updates',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_section_img_75',
            'label' => 'Image: Galentine\'s 2026',
            'name' => 'section_img_75',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_76',
            'label' => 'Image: Triple Anniversary Celebration',
            'name' => 'section_img_76',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_img_77',
            'label' => 'Image: Manille Céramique Pottery Stud',
            'name' => 'section_img_77',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_section_txt_78',
            'label' => 'Text: Latest Updates &amp; Insights...',
            'name' => 'section_txt_78',
            'type' => 'text',
            'default_value' => 'Latest Updates &amp; Insights',
        ),

        array(
            'key' => 'field_section_txt_79',
            'label' => 'Text: Galentine\'s 2026: All Things P...',
            'name' => 'section_txt_79',
            'type' => 'text',
            'default_value' => 'Galentine\'s 2026: All Things Pretty!',
        ),

        array(
            'key' => 'field_section_txt_80',
            'label' => 'Text: A Look Back on Our Triple Anni...',
            'name' => 'section_txt_80',
            'type' => 'text',
            'default_value' => 'A Look Back on Our Triple Anniversary, Pinoy Big Brother: KINGS Edition',
        ),

        array(
            'key' => 'field_section_txt_81',
            'label' => 'Text: Manille Céramique, your neighb...',
            'name' => 'section_txt_81',
            'type' => 'textarea',
            'default_value' => 'Manille Céramique, your neighborhood pottery studio at The Kings City
                Club!',
        ),

        array(
            'key' => 'field_section_txt_82',
            'label' => 'Text: Last February 28, 2026, The Ki...',
            'name' => 'section_txt_82',
            'type' => 'textarea',
            'default_value' => 'Last February 28, 2026, The Kings City Club members celebrated love,
                friendship, and community at Galentine\'s 2026 in collaboration with Cathartic PH. The event brought
                together...',
        ),

        array(
            'key' => 'field_section_txt_83',
            'label' => 'Text: Last January 31, 2026, our com...',
            'name' => 'section_txt_83',
            'type' => 'textarea',
            'default_value' => 'Last January 31, 2026, our community members of Kings Manpower, The Kings
                City Club and Taza Coffee Manila, gathered for a vibrant triple-anniversary celebration! Inspired by the
                fun and..',
        ),

        array(
            'key' => 'field_section_txt_84',
            'label' => 'Text: Manille Céramique, your neighb...',
            'name' => 'section_txt_84',
            'type' => 'textarea',
            'default_value' => 'Manille Céramique, your neighborhood pottery studio in the South, is
                finally OPEN! What started as months of preparation, planning, and passion has finally taken shape
                through Manille Céramique....',
        ),

        array(
            'key' => 'field_section_txt_85',
            'label' => 'Text: The News...',
            'name' => 'section_txt_85',
            'type' => 'text',
            'default_value' => 'The News',
        ),

        array(
            'key' => 'field_section_txt_87',
            'label' => 'Text: 1 min read...',
            'name' => 'section_txt_87',
            'type' => 'text',
            'default_value' => '1 min read',
        ),

        array(
            'key' => 'field_section_txt_88',
            'label' => 'Text: 1 min read...',
            'name' => 'section_txt_88',
            'type' => 'text',
            'default_value' => '1 min read',
        ),

        array(
            'key' => 'field_section_txt_89',
            'label' => 'Text: 1 min read...',
            'name' => 'section_txt_89',
            'type' => 'text',
            'default_value' => '1 min read',
        ),

    ),
    'location' => array(
        array(
            array(
                'param' => 'page_type',
                'operator' => '==',
                'value' => 'front_page',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
));

acf_add_local_field_group(array(
    'key' => 'group_about',
    'title' => 'About Us Content',
    'fields' => array(

        array(
            'key' => 'field_tab_group_about_1',
            'label' => 'Hero Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_about_overline_3',
            'label' => 'Overline #3',
            'name' => 'overline_3',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_h1_1',
            'label' => 'Heading 1 #1',
            'name' => 'h1_1',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_2',
            'label' => 'Paragraph #2',
            'name' => 'p_2',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_about_image_4',
            'label' => 'Image #4',
            'name' => 'image_4',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_about_image_5',
            'label' => 'Image #5',
            'name' => 'image_5',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_about_image_6',
            'label' => 'Image #6',
            'name' => 'image_6',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_tab_group_about_2',
            'label' => 'Story Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_about_image_12',
            'label' => 'Image #12',
            'name' => 'image_12',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_about_overline_11',
            'label' => 'Overline #11',
            'name' => 'overline_11',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_h2_8',
            'label' => 'Heading 2 #8',
            'name' => 'h2_8',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_9',
            'label' => 'Paragraph #9',
            'name' => 'p_9',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_about_p_10',
            'label' => 'Paragraph #10',
            'name' => 'p_10',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_about_3',
            'label' => 'Map Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_about_image_18',
            'label' => 'Image #18',
            'name' => 'image_18',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_about_overline_17',
            'label' => 'Overline #17',
            'name' => 'overline_17',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_h2_14',
            'label' => 'Heading 2 #14',
            'name' => 'h2_14',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_15',
            'label' => 'Paragraph #15',
            'name' => 'p_15',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_about_p_16',
            'label' => 'Paragraph #16',
            'name' => 'p_16',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_about_4',
            'label' => 'Core Values Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_about_overline_29',
            'label' => 'Overline #29',
            'name' => 'overline_29',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_h2_20',
            'label' => 'Heading 2 #20',
            'name' => 'h2_20',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_h3_21',
            'label' => 'Heading 3 #21',
            'name' => 'h3_21',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_25',
            'label' => 'Paragraph #25',
            'name' => 'p_25',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_about_h3_22',
            'label' => 'Heading 3 #22',
            'name' => 'h3_22',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_26',
            'label' => 'Paragraph #26',
            'name' => 'p_26',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_about_h3_23',
            'label' => 'Heading 3 #23',
            'name' => 'h3_23',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_27',
            'label' => 'Paragraph #27',
            'name' => 'p_27',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_about_h3_24',
            'label' => 'Heading 3 #24',
            'name' => 'h3_24',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_28',
            'label' => 'Paragraph #28',
            'name' => 'p_28',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_about_5',
            'label' => 'Section 5',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_about_overline_50',
            'label' => 'Overline #50',
            'name' => 'overline_50',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_h2_31',
            'label' => 'Heading 2 #31',
            'name' => 'h2_31',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_h3_32',
            'label' => 'Heading 3 #32',
            'name' => 'h3_32',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_41',
            'label' => 'Paragraph #41',
            'name' => 'p_41',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_about_h3_33',
            'label' => 'Heading 3 #33',
            'name' => 'h3_33',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_42',
            'label' => 'Paragraph #42',
            'name' => 'p_42',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_about_h3_34',
            'label' => 'Heading 3 #34',
            'name' => 'h3_34',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_43',
            'label' => 'Paragraph #43',
            'name' => 'p_43',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_about_h3_35',
            'label' => 'Heading 3 #35',
            'name' => 'h3_35',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_44',
            'label' => 'Paragraph #44',
            'name' => 'p_44',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_about_h3_36',
            'label' => 'Heading 3 #36',
            'name' => 'h3_36',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_45',
            'label' => 'Paragraph #45',
            'name' => 'p_45',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_about_h3_37',
            'label' => 'Heading 3 #37',
            'name' => 'h3_37',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_46',
            'label' => 'Paragraph #46',
            'name' => 'p_46',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_about_h3_38',
            'label' => 'Heading 3 #38',
            'name' => 'h3_38',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_47',
            'label' => 'Paragraph #47',
            'name' => 'p_47',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_about_h3_39',
            'label' => 'Heading 3 #39',
            'name' => 'h3_39',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_48',
            'label' => 'Paragraph #48',
            'name' => 'p_48',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_about_h3_40',
            'label' => 'Heading 3 #40',
            'name' => 'h3_40',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_about_p_49',
            'label' => 'Paragraph #49',
            'name' => 'p_49',
            'type' => 'textarea',
        ),



        array(
            'key' => 'field_tab_group_about_mv',
            'label' => 'Mission and Vision',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_group_about_overline_mv_mission',
            'label' => 'Mission Overline',
            'name' => 'overline_mv_mission',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_about_h3_mv_mission',
            'label' => 'Mission Heading',
            'name' => 'h3_mv_mission',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_about_p_mv_mission',
            'label' => 'Mission Text',
            'name' => 'p_mv_mission',
            'type' => 'textarea',
        ),
        array(
            'key' => 'field_group_about_overline_mv_vision',
            'label' => 'Vision Overline',
            'name' => 'overline_mv_vision',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_about_h3_mv_vision',
            'label' => 'Vision Heading',
            'name' => 'h3_mv_vision',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_about_p_mv_vision',
            'label' => 'Vision Text',
            'name' => 'p_mv_vision',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_about_perks',
            'label' => 'Membership Perks',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_group_about_pass_image',
            'label' => 'Pass Image',
            'name' => 'about_pass_image',
            'type' => 'image',
            'return_format' => 'array',
        ),
        array(
            'key' => 'field_group_about_pass_overline',
            'label' => 'Pass Overline',
            'name' => 'about_pass_overline',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_about_pass_heading',
            'label' => 'Pass Heading',
            'name' => 'about_pass_heading',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_about_pass_subtext',
            'label' => 'Pass Subtext',
            'name' => 'about_pass_subtext',
            'type' => 'textarea',
        ),
        array(
            'key' => 'field_group_about_pass_perk_1',
            'label' => 'Perk 1',
            'name' => 'about_pass_perk_1',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_about_pass_perk_2',
            'label' => 'Perk 2',
            'name' => 'about_pass_perk_2',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_about_pass_perk_3',
            'label' => 'Perk 3',
            'name' => 'about_pass_perk_3',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_about_pass_perk_4',
            'label' => 'Perk 4',
            'name' => 'about_pass_perk_4',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_about_pass_perk_5',
            'label' => 'Perk 5',
            'name' => 'about_pass_perk_5',
            'type' => 'text',
        ),
        array(
            'key' => 'field_tab_group_about_community',
            'label' => 'Community Section',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_group_about_community_image',
            'label' => 'Community Image',
            'name' => 'community_image',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),
        array(
            'key' => 'field_group_about_overline_community',
            'label' => 'Community Overline',
            'name' => 'overline_community',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_about_h2_community',
            'label' => 'Community Heading',
            'name' => 'h2_community',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_about_p_community_1',
            'label' => 'Community Paragraph 1',
            'name' => 'p_community_1',
            'type' => 'textarea',
        ),
        array(
            'key' => 'field_group_about_p_community_2',
            'label' => 'Community Paragraph 2',
            'name' => 'p_community_2',
            'type' => 'textarea',
        ),

    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-about.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
));

acf_add_local_field_group(array(
    'key' => 'group_spaces',
    'title' => 'Spaces Content',
    'fields' => array(

        array(
            'key' => 'field_tab_group_spaces_1',
            'label' => 'Hero Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_spaces_overline_3',
            'label' => 'Overline #3',
            'name' => 'overline_3',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_spaces_h1_1',
            'label' => 'Heading 1 #1',
            'name' => 'h1_1',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_spaces_p_2',
            'label' => 'Paragraph #2',
            'name' => 'p_2',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_spaces_image_4',
            'label' => 'Image #4',
            'name' => 'image_4',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_image_5',
            'label' => 'Image #5',
            'name' => 'image_5',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_image_6',
            'label' => 'Image #6',
            'name' => 'image_6',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_tab_group_spaces_2',
            'label' => 'Spaces Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_spaces_image_12',
            'label' => 'Image #12',
            'name' => 'image_12',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_overline_11',
            'label' => 'Overline #11',
            'name' => 'overline_11',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_spaces_h2_8',
            'label' => 'Heading 2 #8',
            'name' => 'h2_8',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_spaces_p_9',
            'label' => 'Paragraph #9',
            'name' => 'p_9',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_spaces_p_10',
            'label' => 'Paragraph #10',
            'name' => 'p_10',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_spaces_3',
            'label' => 'Spaces Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_spaces_image_18',
            'label' => 'Image #18',
            'name' => 'image_18',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_overline_17',
            'label' => 'Overline #17',
            'name' => 'overline_17',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_spaces_h2_14',
            'label' => 'Heading 2 #14',
            'name' => 'h2_14',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_spaces_p_15',
            'label' => 'Paragraph #15',
            'name' => 'p_15',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_spaces_p_16',
            'label' => 'Paragraph #16',
            'name' => 'p_16',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_spaces_4',
            'label' => 'Spaces Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_spaces_image_24',
            'label' => 'Image #24',
            'name' => 'image_24',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_overline_23',
            'label' => 'Overline #23',
            'name' => 'overline_23',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_spaces_h2_20',
            'label' => 'Heading 2 #20',
            'name' => 'h2_20',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_spaces_p_21',
            'label' => 'Paragraph #21',
            'name' => 'p_21',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_spaces_p_22',
            'label' => 'Paragraph #22',
            'name' => 'p_22',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_spaces_5',
            'label' => 'Spaces Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_spaces_image_30',
            'label' => 'Image #30',
            'name' => 'image_30',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_overline_29',
            'label' => 'Overline #29',
            'name' => 'overline_29',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_spaces_h2_26',
            'label' => 'Heading 2 #26',
            'name' => 'h2_26',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_spaces_p_27',
            'label' => 'Paragraph #27',
            'name' => 'p_27',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_spaces_p_28',
            'label' => 'Paragraph #28',
            'name' => 'p_28',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_spaces_6',
            'label' => 'Spaces Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_spaces_image_36',
            'label' => 'Image #36',
            'name' => 'image_36',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_overline_35',
            'label' => 'Overline #35',
            'name' => 'overline_35',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_spaces_h2_32',
            'label' => 'Heading 2 #32',
            'name' => 'h2_32',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_spaces_p_33',
            'label' => 'Paragraph #33',
            'name' => 'p_33',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_spaces_p_34',
            'label' => 'Paragraph #34',
            'name' => 'p_34',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_spaces_7',
            'label' => 'Section 7',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_spaces_overline_43',
            'label' => 'Overline #43',
            'name' => 'overline_43',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_spaces_h2_38',
            'label' => 'Heading 2 #38',
            'name' => 'h2_38',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_spaces_p_39',
            'label' => 'Paragraph #39',
            'name' => 'p_39',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_spaces_p_40',
            'label' => 'Paragraph #40',
            'name' => 'p_40',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_spaces_p_41',
            'label' => 'Paragraph #41',
            'name' => 'p_41',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_spaces_p_42',
            'label' => 'Paragraph #42',
            'name' => 'p_42',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_spaces_8',
            'label' => 'Section 8',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_spaces_image_45',
            'label' => 'Image #45',
            'name' => 'image_45',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_image_46',
            'label' => 'Image #46',
            'name' => 'image_46',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_image_47',
            'label' => 'Image #47',
            'name' => 'image_47',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_image_48',
            'label' => 'Image #48',
            'name' => 'image_48',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_image_49',
            'label' => 'Image #49',
            'name' => 'image_49',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_image_50',
            'label' => 'Image #50',
            'name' => 'image_50',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_image_51',
            'label' => 'Image #51',
            'name' => 'image_51',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_image_52',
            'label' => 'Image #52',
            'name' => 'image_52',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_image_53',
            'label' => 'Image #53',
            'name' => 'image_53',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_spaces_image_54',
            'label' => 'Image #54',
            'name' => 'image_54',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-spaces.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
));

acf_add_local_field_group(array(
    'key' => 'group_impact',
    'title' => 'Impact Content',
    'fields' => array(

        array(
            'key' => 'field_tab_group_impact_1',
            'label' => 'Hero Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_impact_overline_3',
            'label' => 'Overline #3',
            'name' => 'overline_3',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_impact_h1_1',
            'label' => 'Heading 1 #1',
            'name' => 'h1_1',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_impact_p_2',
            'label' => 'Paragraph #2',
            'name' => 'p_2',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_impact_image_4',
            'label' => 'Image #4',
            'name' => 'image_4',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_impact_image_5',
            'label' => 'Image #5',
            'name' => 'image_5',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_impact_image_6',
            'label' => 'Image #6',
            'name' => 'image_6',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_tab_group_impact_2',
            'label' => 'Section_About Impact Initiatives Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_impact_p_8',
            'label' => 'Paragraph #8',
            'name' => 'p_8',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_impact_p_9',
            'label' => 'Paragraph #9',
            'name' => 'p_9',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_impact_p_10',
            'label' => 'Paragraph #10',
            'name' => 'p_10',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_impact_p_11',
            'label' => 'Paragraph #11',
            'name' => 'p_11',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_impact_p_12',
            'label' => 'Paragraph #12',
            'name' => 'p_12',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_impact_p_13',
            'label' => 'Paragraph #13',
            'name' => 'p_13',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_impact_p_14',
            'label' => 'Paragraph #14',
            'name' => 'p_14',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_impact_p_15',
            'label' => 'Paragraph #15',
            'name' => 'p_15',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_impact_p_16',
            'label' => 'Paragraph #16',
            'name' => 'p_16',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_impact_3',
            'label' => 'Impact Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_impact_image_22',
            'label' => 'Image #22',
            'name' => 'image_22',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_impact_overline_21',
            'label' => 'Overline #21',
            'name' => 'overline_21',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_impact_h2_18',
            'label' => 'Heading 2 #18',
            'name' => 'h2_18',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_impact_p_19',
            'label' => 'Paragraph #19',
            'name' => 'p_19',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_impact_p_20',
            'label' => 'Paragraph #20',
            'name' => 'p_20',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_impact_4',
            'label' => 'Cda Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_impact_image_28',
            'label' => 'Image #28',
            'name' => 'image_28',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_impact_overline_27',
            'label' => 'Overline #27',
            'name' => 'overline_27',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_impact_h2_24',
            'label' => 'Heading 2 #24',
            'name' => 'h2_24',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_impact_p_25',
            'label' => 'Paragraph #25',
            'name' => 'p_25',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_impact_p_26',
            'label' => 'Paragraph #26',
            'name' => 'p_26',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_impact_5',
            'label' => 'Section_About Impact Conscious Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_impact_overline_33',
            'label' => 'Overline #33',
            'name' => 'overline_33',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_impact_h2_30',
            'label' => 'Heading 2 #30',
            'name' => 'h2_30',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_impact_p_31',
            'label' => 'Paragraph #31',
            'name' => 'p_31',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_impact_p_32',
            'label' => 'Paragraph #32',
            'name' => 'p_32',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_impact_6',
            'label' => 'Impact Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_impact_overline_37',
            'label' => 'Overline #37',
            'name' => 'overline_37',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_impact_h2_35',
            'label' => 'Heading 2 #35',
            'name' => 'h2_35',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_impact_p_36',
            'label' => 'Paragraph #36',
            'name' => 'p_36',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_impact_image_38',
            'label' => 'Image #38',
            'name' => 'image_38',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_impact_image_39',
            'label' => 'Image #39',
            'name' => 'image_39',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_impact_image_40',
            'label' => 'Image #40',
            'name' => 'image_40',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_impact_image_41',
            'label' => 'Image #41',
            'name' => 'image_41',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_impact_image_42',
            'label' => 'Image #42',
            'name' => 'image_42',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_impact_image_43',
            'label' => 'Image #43',
            'name' => 'image_43',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_impact_image_44',
            'label' => 'Image #44',
            'name' => 'image_44',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_impact_image_45',
            'label' => 'Image #45',
            'name' => 'image_45',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_impact_image_46',
            'label' => 'Image #46',
            'name' => 'image_46',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-impact.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
));

acf_add_local_field_group(array(
    'key' => 'group_offshoring',
    'title' => 'Offshoring Content',
    'fields' => array(

        array(
            'key' => 'field_tab_group_offshoring_1',
            'label' => 'Hero Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_offshoring_overline_3',
            'label' => 'Overline #3',
            'name' => 'overline_3',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_offshoring_h1_1',
            'label' => 'Heading 1 #1',
            'name' => 'h1_1',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_offshoring_p_2',
            'label' => 'Paragraph #2',
            'name' => 'p_2',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_image_4',
            'label' => 'Image #4',
            'name' => 'image_4',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_offshoring_image_5',
            'label' => 'Image #5',
            'name' => 'image_5',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_offshoring_image_6',
            'label' => 'Image #6',
            'name' => 'image_6',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_tab_group_offshoring_2',
            'label' => 'Offshoring Process',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_offshoring_overline_18',
            'label' => 'Overline #18',
            'name' => 'overline_18',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_offshoring_h2_8',
            'label' => 'Heading 2 #8',
            'name' => 'h2_8',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_offshoring_p_13',
            'label' => 'Paragraph #13',
            'name' => 'p_13',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_h3_9',
            'label' => 'Heading 3 #9',
            'name' => 'h3_9',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_offshoring_p_14',
            'label' => 'Paragraph #14',
            'name' => 'p_14',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_image_19',
            'label' => 'Image #19',
            'name' => 'image_19',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_offshoring_h3_10',
            'label' => 'Heading 3 #10',
            'name' => 'h3_10',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_offshoring_p_15',
            'label' => 'Paragraph #15',
            'name' => 'p_15',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_image_20',
            'label' => 'Image #20',
            'name' => 'image_20',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_offshoring_h3_11',
            'label' => 'Heading 3 #11',
            'name' => 'h3_11',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_offshoring_p_16',
            'label' => 'Paragraph #16',
            'name' => 'p_16',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_image_21',
            'label' => 'Image #21',
            'name' => 'image_21',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_offshoring_h3_12',
            'label' => 'Heading 3 #12',
            'name' => 'h3_12',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_offshoring_p_17',
            'label' => 'Paragraph #17',
            'name' => 'p_17',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_image_22',
            'label' => 'Image #22',
            'name' => 'image_22',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_tab_group_offshoring_models',
            'label' => 'Offshoring Models',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_group_offshoring_overline_models',
            'label' => 'Overline Models',
            'name' => 'overline_models',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_offshoring_h2_models',
            'label' => 'Heading Models',
            'name' => 'h2_models',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_offshoring_p_intro_models',
            'label' => 'Intro Text Models',
            'name' => 'p_intro_models',
            'type' => 'textarea',
        ),
        array(
            'key' => 'field_group_offshoring_h3_model1',
            'label' => 'Model 1 Heading',
            'name' => 'h3_model1',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_offshoring_p_model1',
            'label' => 'Model 1 Description',
            'name' => 'p_model1',
            'type' => 'textarea',
        ),
        array(
            'key' => 'field_group_offshoring_model1_bullets',
            'label' => 'Model 1 Bullets (use <li> elements)',
            'name' => 'model1_bullets',
            'type' => 'wysiwyg',
        ),
        array(
            'key' => 'field_group_offshoring_model1_btn_text',
            'label' => 'Model 1 Button Text',
            'name' => 'model1_btn_text',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_offshoring_model1_btn_url',
            'label' => 'Model 1 Button URL',
            'name' => 'model1_btn_url',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_offshoring_h3_model2',
            'label' => 'Model 2 Heading',
            'name' => 'h3_model2',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_offshoring_p_model2',
            'label' => 'Model 2 Description',
            'name' => 'p_model2',
            'type' => 'textarea',
        ),
        array(
            'key' => 'field_group_offshoring_model2_bullets',
            'label' => 'Model 2 Bullets (use <li> elements)',
            'name' => 'model2_bullets',
            'type' => 'wysiwyg',
        ),
        array(
            'key' => 'field_group_offshoring_model2_btn_text',
            'label' => 'Model 2 Button Text',
            'name' => 'model2_btn_text',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_offshoring_model2_btn_url',
            'label' => 'Model 2 Button URL',
            'name' => 'model2_btn_url',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_offshoring_billing_title',
            'label' => 'Billing Title',
            'name' => 'billing_title',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_offshoring_p_billing',
            'label' => 'Billing Description',
            'name' => 'p_billing',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_offshoring_3',
            'label' => 'Section 3',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_offshoring_overline_38',
            'label' => 'Overline #38',
            'name' => 'overline_38',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_offshoring_h2_24',
            'label' => 'Heading 2 #24',
            'name' => 'h2_24',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_offshoring_p_25',
            'label' => 'Paragraph #25',
            'name' => 'p_25',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_26',
            'label' => 'Paragraph #26',
            'name' => 'p_26',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_27',
            'label' => 'Paragraph #27',
            'name' => 'p_27',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_28',
            'label' => 'Paragraph #28',
            'name' => 'p_28',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_29',
            'label' => 'Paragraph #29',
            'name' => 'p_29',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_30',
            'label' => 'Paragraph #30',
            'name' => 'p_30',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_31',
            'label' => 'Paragraph #31',
            'name' => 'p_31',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_32',
            'label' => 'Paragraph #32',
            'name' => 'p_32',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_33',
            'label' => 'Paragraph #33',
            'name' => 'p_33',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_34',
            'label' => 'Paragraph #34',
            'name' => 'p_34',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_35',
            'label' => 'Paragraph #35',
            'name' => 'p_35',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_36',
            'label' => 'Paragraph #36',
            'name' => 'p_36',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_37',
            'label' => 'Paragraph #37',
            'name' => 'p_37',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_offshoring_4',
            'label' => 'Section 4',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_offshoring_overline_43',
            'label' => 'Overline #43',
            'name' => 'overline_43',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_offshoring_h2_40',
            'label' => 'Heading 2 #40',
            'name' => 'h2_40',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_offshoring_p_41',
            'label' => 'Paragraph #41',
            'name' => 'p_41',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_42',
            'label' => 'Paragraph #42',
            'name' => 'p_42',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_offshoring_5',
            'label' => 'Section 5',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_offshoring_overline_50',
            'label' => 'Overline #50',
            'name' => 'overline_50',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_offshoring_h2_45',
            'label' => 'Heading 2 #45',
            'name' => 'h2_45',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_offshoring_p_46',
            'label' => 'Paragraph #46',
            'name' => 'p_46',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_47',
            'label' => 'Paragraph #47',
            'name' => 'p_47',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_48',
            'label' => 'Paragraph #48',
            'name' => 'p_48',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_offshoring_p_49',
            'label' => 'Paragraph #49',
            'name' => 'p_49',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_offshoring_6',
            'label' => 'Section 6',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_offshoring_image_52',
            'label' => 'Image #52',
            'name' => 'image_52',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_offshoring_image_53',
            'label' => 'Image #53',
            'name' => 'image_53',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_offshoring_image_54',
            'label' => 'Image #54',
            'name' => 'image_54',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_offshoring_image_55',
            'label' => 'Image #55',
            'name' => 'image_55',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_offshoring_image_56',
            'label' => 'Image #56',
            'name' => 'image_56',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_offshoring_image_57',
            'label' => 'Image #57',
            'name' => 'image_57',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_offshoring_image_58',
            'label' => 'Image #58',
            'name' => 'image_58',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_offshoring_image_59',
            'label' => 'Image #59',
            'name' => 'image_59',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_offshoring_image_60',
            'label' => 'Image #60',
            'name' => 'image_60',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_offshoring_image_61',
            'label' => 'Image #61',
            'name' => 'image_61',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-offshoring.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
));

acf_add_local_field_group(array(
    'key' => 'group_our_brands',
    'title' => 'Our Brands Content',
    'fields' => array(

        array(
            'key' => 'field_tab_group_our_brands_1',
            'label' => 'Hero Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_our_brands_overline_3',
            'label' => 'Overline #3',
            'name' => 'overline_3',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_our_brands_h1_1',
            'label' => 'Heading 1 #1',
            'name' => 'h1_1',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_our_brands_p_2',
            'label' => 'Paragraph #2',
            'name' => 'p_2',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_our_brands_image_4',
            'label' => 'Image #4',
            'name' => 'image_4',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_5',
            'label' => 'Image #5',
            'name' => 'image_5',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_6',
            'label' => 'Image #6',
            'name' => 'image_6',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_tab_group_our_brands_2',
            'label' => 'Intro Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_our_brands_image_11',
            'label' => 'Image #11',
            'name' => 'image_11',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_overline_10',
            'label' => 'Overline #10',
            'name' => 'overline_10',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_our_brands_h2_8',
            'label' => 'Heading 2 #8',
            'name' => 'h2_8',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_our_brands_p_9',
            'label' => 'Paragraph #9',
            'name' => 'p_9',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_our_brands_3',
            'label' => 'Logo Banner Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_our_brands_image_13',
            'label' => 'Image #13',
            'name' => 'image_13',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_14',
            'label' => 'Image #14',
            'name' => 'image_14',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_15',
            'label' => 'Image #15',
            'name' => 'image_15',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_16',
            'label' => 'Image #16',
            'name' => 'image_16',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_17',
            'label' => 'Image #17',
            'name' => 'image_17',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_tab_group_our_brands_4',
            'label' => 'Section 4',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_our_brands_overline_30',
            'label' => 'Overline #30',
            'name' => 'overline_30',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_our_brands_h2_19',
            'label' => 'Heading 2 #19',
            'name' => 'h2_19',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_our_brands_h3_20',
            'label' => 'Heading 3 #20',
            'name' => 'h3_20',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_our_brands_p_25',
            'label' => 'Paragraph #25',
            'name' => 'p_25',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_our_brands_h3_21',
            'label' => 'Heading 3 #21',
            'name' => 'h3_21',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_our_brands_p_26',
            'label' => 'Paragraph #26',
            'name' => 'p_26',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_our_brands_h3_22',
            'label' => 'Heading 3 #22',
            'name' => 'h3_22',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_our_brands_p_27',
            'label' => 'Paragraph #27',
            'name' => 'p_27',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_our_brands_h3_23',
            'label' => 'Heading 3 #23',
            'name' => 'h3_23',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_our_brands_p_28',
            'label' => 'Paragraph #28',
            'name' => 'p_28',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_our_brands_h3_24',
            'label' => 'Heading 3 #24',
            'name' => 'h3_24',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_our_brands_p_29',
            'label' => 'Paragraph #29',
            'name' => 'p_29',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_our_brands_5',
            'label' => 'Pass Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_our_brands_overline_34',
            'label' => 'Overline #34',
            'name' => 'overline_34',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_our_brands_h2_32',
            'label' => 'Heading 2 #32',
            'name' => 'h2_32',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_our_brands_p_33',
            'label' => 'Paragraph #33',
            'name' => 'p_33',
            'type' => 'textarea',
        ),

        array(
        array(
            'key' => 'field_group_our_brands_perk_1',
            'label' => 'Perk 1 Text',
            'name' => 'perk_1',
            'type' => 'text',
            'default_value' => 'A dedicated home location 24/7 access',
        ),

        array(
            'key' => 'field_group_our_brands_perk_2',
            'label' => 'Perk 2 Text',
            'name' => 'perk_2',
            'type' => 'text',
            'default_value' => 'Meeting, conference, training and workshop rooms',
        ),

        array(
            'key' => 'field_group_our_brands_perk_3',
            'label' => 'Perk 3 Text',
            'name' => 'perk_3',
            'type' => 'text',
            'default_value' => 'Event spaces, podcast studios, and photography studios',
        ),

        array(
            'key' => 'field_group_our_brands_perk_4',
            'label' => 'Perk 4 Text',
            'name' => 'perk_4',
            'type' => 'text',
            'default_value' => 'Premium Gym access & Kings Club wellness program',
        ),

        array(
            'key' => 'field_group_our_brands_perk_5',
            'label' => 'Perk 5 Text',
            'name' => 'perk_5',
            'type' => 'text',
            'default_value' => 'High speed Wi-Fi, fully stocked kitchens, unlimited printing',
        ),

            'key' => 'field_group_our_brands_image_35',
            'label' => 'Image #35',
            'name' => 'image_35',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_tab_group_our_brands_6',
            'label' => 'Section 6',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_our_brands_image_37',
            'label' => 'Image #37',
            'name' => 'image_37',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_38',
            'label' => 'Image #38',
            'name' => 'image_38',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_39',
            'label' => 'Image #39',
            'name' => 'image_39',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_40',
            'label' => 'Image #40',
            'name' => 'image_40',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_41',
            'label' => 'Image #41',
            'name' => 'image_41',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_42',
            'label' => 'Image #42',
            'name' => 'image_42',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_43',
            'label' => 'Image #43',
            'name' => 'image_43',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_44',
            'label' => 'Image #44',
            'name' => 'image_44',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_45',
            'label' => 'Image #45',
            'name' => 'image_45',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_46',
            'label' => 'Image #46',
            'name' => 'image_46',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_47',
            'label' => 'Image #47',
            'name' => 'image_47',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_our_brands_image_48',
            'label' => 'Image #48',
            'name' => 'image_48',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-our-brands.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
));

acf_add_local_field_group(array(
    'key' => 'group_news',
    'title' => 'News Content',
    'fields' => array(

        array(
            'key' => 'field_tab_group_news_1',
            'label' => 'Hero Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_news_overline_3',
            'label' => 'Overline #3',
            'name' => 'overline_3',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h1_1',
            'label' => 'Heading 1 #1',
            'name' => 'h1_1',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_p_2',
            'label' => 'Paragraph #2',
            'name' => 'p_2',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_news_2',
            'label' => 'Section 2',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_news_overline_11',
            'label' => 'Overline #11',
            'name' => 'overline_11',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h3_5',
            'label' => 'Heading 3 #5',
            'name' => 'h3_5',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_p_8',
            'label' => 'Paragraph #8',
            'name' => 'p_8',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_news_overline_12',
            'label' => 'Overline #12',
            'name' => 'overline_12',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h3_6',
            'label' => 'Heading 3 #6',
            'name' => 'h3_6',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_p_9',
            'label' => 'Paragraph #9',
            'name' => 'p_9',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_news_overline_13',
            'label' => 'Overline #13',
            'name' => 'overline_13',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h3_7',
            'label' => 'Heading 3 #7',
            'name' => 'h3_7',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_p_10',
            'label' => 'Paragraph #10',
            'name' => 'p_10',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_news_3',
            'label' => 'Section 3',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_news_overline_21',
            'label' => 'Overline #21',
            'name' => 'overline_21',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h3_15',
            'label' => 'Heading 3 #15',
            'name' => 'h3_15',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_p_18',
            'label' => 'Paragraph #18',
            'name' => 'p_18',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_news_overline_22',
            'label' => 'Overline #22',
            'name' => 'overline_22',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h3_16',
            'label' => 'Heading 3 #16',
            'name' => 'h3_16',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_p_19',
            'label' => 'Paragraph #19',
            'name' => 'p_19',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_news_overline_23',
            'label' => 'Overline #23',
            'name' => 'overline_23',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h3_17',
            'label' => 'Heading 3 #17',
            'name' => 'h3_17',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_p_20',
            'label' => 'Paragraph #20',
            'name' => 'p_20',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_news_4',
            'label' => 'Section 4',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_news_overline_31',
            'label' => 'Overline #31',
            'name' => 'overline_31',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h3_25',
            'label' => 'Heading 3 #25',
            'name' => 'h3_25',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_p_28',
            'label' => 'Paragraph #28',
            'name' => 'p_28',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_news_overline_32',
            'label' => 'Overline #32',
            'name' => 'overline_32',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h3_26',
            'label' => 'Heading 3 #26',
            'name' => 'h3_26',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_p_29',
            'label' => 'Paragraph #29',
            'name' => 'p_29',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_news_overline_33',
            'label' => 'Overline #33',
            'name' => 'overline_33',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h3_27',
            'label' => 'Heading 3 #27',
            'name' => 'h3_27',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_p_30',
            'label' => 'Paragraph #30',
            'name' => 'p_30',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_tab_group_news_5',
            'label' => 'Section 5',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_news_overline_39',
            'label' => 'Overline #39',
            'name' => 'overline_39',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h3_35',
            'label' => 'Heading 3 #35',
            'name' => 'h3_35',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_p_38',
            'label' => 'Paragraph #38',
            'name' => 'p_38',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_news_overline_40',
            'label' => 'Overline #40',
            'name' => 'overline_40',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h3_36',
            'label' => 'Heading 3 #36',
            'name' => 'h3_36',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_overline_41',
            'label' => 'Overline #41',
            'name' => 'overline_41',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h3_37',
            'label' => 'Heading 3 #37',
            'name' => 'h3_37',
            'type' => 'text',
        ),

        array(
            'key' => 'field_tab_group_news_6',
            'label' => 'Section 6',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_news_overline_49',
            'label' => 'Overline #49',
            'name' => 'overline_49',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h3_43',
            'label' => 'Heading 3 #43',
            'name' => 'h3_43',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_p_46',
            'label' => 'Paragraph #46',
            'name' => 'p_46',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_news_overline_50',
            'label' => 'Overline #50',
            'name' => 'overline_50',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h3_44',
            'label' => 'Heading 3 #44',
            'name' => 'h3_44',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_p_47',
            'label' => 'Paragraph #47',
            'name' => 'p_47',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_news_overline_51',
            'label' => 'Overline #51',
            'name' => 'overline_51',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_h3_45',
            'label' => 'Heading 3 #45',
            'name' => 'h3_45',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_news_p_48',
            'label' => 'Paragraph #48',
            'name' => 'p_48',
            'type' => 'textarea',
        ),

    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-news.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
));

acf_add_local_field_group(array(
    'key' => 'group_apply',
    'title' => 'Apply Content',
    'fields' => array(

        array(
            'key' => 'field_tab_group_apply_1',
            'label' => 'Hero Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_apply_overline_3',
            'label' => 'Overline #3',
            'name' => 'overline_3',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_apply_h1_1',
            'label' => 'Heading 1 #1',
            'name' => 'h1_1',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_apply_p_2',
            'label' => 'Paragraph #2',
            'name' => 'p_2',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_apply_image_4',
            'label' => 'Image #4',
            'name' => 'image_4',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_apply_image_5',
            'label' => 'Image #5',
            'name' => 'image_5',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_apply_image_6',
            'label' => 'Image #6',
            'name' => 'image_6',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_tab_group_apply_2',
            'label' => 'Spaces View',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_apply_overline_18',
            'label' => 'Overline #18',
            'name' => 'overline_18',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_apply_h2_8',
            'label' => 'Heading 2 #8',
            'name' => 'h2_8',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_apply_p_14',
            'label' => 'Paragraph #14',
            'name' => 'p_14',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_apply_h3_9',
            'label' => 'Heading 3 #9',
            'name' => 'h3_9',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_apply_h3_10',
            'label' => 'Heading 3 #10',
            'name' => 'h3_10',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_apply_p_15',
            'label' => 'Paragraph #15',
            'name' => 'p_15',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_apply_sp_label_space_type',
            'label' => 'Which space are you interested in?',
            'name' => 'sp_label_space_type',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sp_label_first_name',
            'label' => 'First Name',
            'name' => 'sp_label_first_name',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sp_label_last_name',
            'label' => 'Last Name',
            'name' => 'sp_label_last_name',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sp_label_email',
            'label' => 'Email Address',
            'name' => 'sp_label_email',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sp_label_phone',
            'label' => 'Phone Number',
            'name' => 'sp_label_phone',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sp_label_company',
            'label' => 'Company / Business Name',
            'name' => 'sp_label_company',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sp_label_country',
            'label' => 'Country',
            'name' => 'sp_label_country',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sp_label_needs',
            'label' => 'Tell Us About Your Needs',
            'name' => 'sp_label_needs',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sp_label_consent',
            'label' => 'Consent Text',
            'name' => 'sp_label_consent',
            'type' => 'textarea',
        ),
        array(
            'key' => 'field_group_apply_sp_btn_submit',
            'label' => 'Submit Button',
            'name' => 'sp_btn_submit',
            'type' => 'text',
        ),

        array(
            'key' => 'field_tab_group_apply_offshoring',
            'label' => 'Offshoring View',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_apply_h3_11',
            'label' => 'Heading 3 #11',
            'name' => 'h3_11',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_apply_p_16',
            'label' => 'Paragraph #16',
            'name' => 'p_16',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_apply_h3_12',
            'label' => 'Heading 3 #12',
            'name' => 'h3_12',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_apply_p_17',
            'label' => 'Paragraph #17',
            'name' => 'p_17',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_apply_off_label_first_name',
            'label' => 'First Name',
            'name' => 'off_label_first_name',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_off_label_last_name',
            'label' => 'Last Name',
            'name' => 'off_label_last_name',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_off_label_email',
            'label' => 'Email Address',
            'name' => 'off_label_email',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_off_label_phone',
            'label' => 'Phone Number',
            'name' => 'off_label_phone',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_off_label_company',
            'label' => 'Company Name',
            'name' => 'off_label_company',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_off_label_country',
            'label' => 'Country',
            'name' => 'off_label_country',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_off_label_website',
            'label' => 'Company Website',
            'name' => 'off_label_website',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_off_label_needs',
            'label' => 'Tell Us About Your Needs Header',
            'name' => 'off_label_needs',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_off_label_service',
            'label' => 'Which service are you interested in?',
            'name' => 'off_label_service',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_off_label_team_size',
            'label' => 'How many staff are you looking to hire?',
            'name' => 'off_label_team_size',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_off_label_roles',
            'label' => 'What type of roles are you looking for?',
            'name' => 'off_label_roles',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_off_label_timeline',
            'label' => 'When are you looking to start?',
            'name' => 'off_label_timeline',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_off_label_source',
            'label' => 'How did you hear about us?',
            'name' => 'off_label_source',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_off_label_notes',
            'label' => 'Additional Notes',
            'name' => 'off_label_notes',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_off_label_consent',
            'label' => 'Consent Text',
            'name' => 'off_label_consent',
            'type' => 'textarea',
        ),
        array(
            'key' => 'field_group_apply_off_btn_submit',
            'label' => 'Submit Button',
            'name' => 'off_btn_submit',
            'type' => 'text',
        ),

        array(
            'key' => 'field_tab_group_apply_sidebar',
            'label' => 'Sidebars',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_apply_h3_contact',
            'label' => 'Get in Touch Heading',
            'name' => 'h3_contact',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_apply_h3_13',
            'label' => 'Heading 3 #13',
            'name' => 'h3_13',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_apply_sb_contact_phone_lbl',
            'label' => 'Contact Phone Label',
            'name' => 'sb_contact_phone_lbl',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sb_contact_phone_val',
            'label' => 'Contact Phone Value',
            'name' => 'sb_contact_phone_val',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sb_contact_email_lbl',
            'label' => 'Contact Email Label',
            'name' => 'sb_contact_email_lbl',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sb_contact_email_val',
            'label' => 'Contact Email Value',
            'name' => 'sb_contact_email_val',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sb_contact_addr_lbl',
            'label' => 'Contact Address Label',
            'name' => 'sb_contact_addr_lbl',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sb_contact_addr_val',
            'label' => 'Contact Address Value',
            'name' => 'sb_contact_addr_val',
            'type' => 'textarea',
        ),
        array(
            'key' => 'field_group_apply_sb_why_kings_btn',
            'label' => 'Why Kings City Button Text',
            'name' => 'sb_why_kings_btn',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sb_why_kings_btn_url',
            'label' => 'Why Kings City Button URL',
            'name' => 'sb_why_kings_btn_url',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sb_link1_txt',
            'label' => 'Helpful Link 1 Text',
            'name' => 'sb_link1_txt',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sb_link1_url',
            'label' => 'Helpful Link 1 URL',
            'name' => 'sb_link1_url',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sb_link2_txt',
            'label' => 'Helpful Link 2 Text',
            'name' => 'sb_link2_txt',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sb_link2_url',
            'label' => 'Helpful Link 2 URL',
            'name' => 'sb_link2_url',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sb_link3_txt',
            'label' => 'Helpful Link 3 Text',
            'name' => 'sb_link3_txt',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sb_link3_url',
            'label' => 'Helpful Link 3 URL',
            'name' => 'sb_link3_url',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sb_link4_txt',
            'label' => 'Helpful Link 4 Text',
            'name' => 'sb_link4_txt',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_apply_sb_link4_url',
            'label' => 'Helpful Link 4 URL',
            'name' => 'sb_link4_url',
            'type' => 'text',
        ),

    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-apply.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
));

acf_add_local_field_group(array(
    'key' => 'group_book_now',
    'title' => 'Book Now Content',
    'fields' => array(

        array(
            'key' => 'field_tab_group_book_now_1',
            'label' => 'Hero Section',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_book_now_overline_3',
            'label' => 'Overline #3',
            'name' => 'overline_3',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_book_now_h1_1',
            'label' => 'Heading 1 #1',
            'name' => 'h1_1',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_book_now_p_2',
            'label' => 'Paragraph #2',
            'name' => 'p_2',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_book_now_image_4',
            'label' => 'Image #4',
            'name' => 'image_4',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_book_now_image_5',
            'label' => 'Image #5',
            'name' => 'image_5',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_book_now_image_6',
            'label' => 'Image #6',
            'name' => 'image_6',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_tab_group_book_now_2',
            'label' => 'Section 2',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),

        array(
            'key' => 'field_group_book_now_image_14',
            'label' => 'Image #14',
            'name' => 'image_14',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_book_now_overline_13',
            'label' => 'Overline #13',
            'name' => 'overline_13',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_book_now_h2_8',
            'label' => 'Heading 2 #8',
            'name' => 'h2_8',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_book_now_p_10',
            'label' => 'Paragraph #10',
            'name' => 'p_10',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_book_now_p_11',
            'label' => 'Paragraph #11',
            'name' => 'p_11',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_book_now_h3_9',
            'label' => 'Heading 3 #9',
            'name' => 'h3_9',
            'type' => 'text',
        ),

        array(
            'key' => 'field_group_book_now_p_12',
            'label' => 'Paragraph #12',
            'name' => 'p_12',
            'type' => 'textarea',
        ),

        array(
            'key' => 'field_group_book_now_image_coworking',
            'label' => 'Co-Working Image',
            'name' => 'image_coworking',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_book_now_image_meeting',
            'label' => 'Meeting Rooms Image',
            'name' => 'image_meeting',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_book_now_image_events',
            'label' => 'Events Place Image',
            'name' => 'image_events',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_book_now_image_office',
            'label' => 'Office Leasing Image',
            'name' => 'image_office',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_group_book_now_image_virtual',
            'label' => 'Virtual Office Image',
            'name' => 'image_virtual',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),

        array(
            'key' => 'field_tab_group_book_now_3',
            'label' => 'Booking Form',
            'name' => '',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_group_book_now_bk_label_est_price',
            'label' => 'Estimated Price Label',
            'name' => 'bk_label_est_price',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_book_now_bk_label_space_type',
            'label' => 'Space Type Label',
            'name' => 'bk_label_space_type',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_book_now_bk_label_first_name',
            'label' => 'First Name Label',
            'name' => 'bk_label_first_name',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_book_now_bk_label_last_name',
            'label' => 'Last Name Label',
            'name' => 'bk_label_last_name',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_book_now_bk_label_email',
            'label' => 'Email Address Label',
            'name' => 'bk_label_email',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_book_now_bk_label_phone',
            'label' => 'Phone Number Label',
            'name' => 'bk_label_phone',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_book_now_bk_label_duration',
            'label' => 'Duration Label',
            'name' => 'bk_label_duration',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_book_now_bk_label_start_date',
            'label' => 'Start Date Label',
            'name' => 'bk_label_start_date',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_book_now_bk_label_special',
            'label' => 'Special Requests Label',
            'name' => 'bk_label_special',
            'type' => 'text',
        ),
        array(
            'key' => 'field_group_book_now_bk_btn_submit',
            'label' => 'Submit Button Text',
            'name' => 'bk_btn_submit',
            'type' => 'text',
        ),

    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-book-now.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
));



acf_add_local_field_group(array(
    'key' => 'group_header_settings',
    'title' => 'Header Settings',
    'fields' => array(

        /* ── Logo Tab ── */
        array(
            'key' => 'field_tab_header_logo',
            'label' => 'Logo',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_header_logo_text',
            'label' => 'Logo Text',
            'name' => 'header_logo_text',
            'type' => 'text',
        ),

        /* ── Nav Links Tab ── */
        array(
            'key' => 'field_tab_header_nav',
            'label' => 'Navigation Links',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_header_nav_more_label',
            'label' => 'More Dropdown Label',
            'name' => 'header_nav_more_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_header_nav_space_hire_label',
            'label' => 'Space Hire Label',
            'name' => 'header_nav_space_hire_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_header_nav_offshoring_label',
            'label' => 'Offshoring Staffing Label',
            'name' => 'header_nav_offshoring_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_header_nav_shop_label',
            'label' => 'Shop Label',
            'name' => 'header_nav_shop_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_header_nav_shop_url',
            'label' => 'Shop URL',
            'name' => 'header_nav_shop_url',
            'type' => 'url',
        ),
        array(
            'key' => 'field_header_nav_apply_label',
            'label' => 'Apply Button Label',
            'name' => 'header_nav_apply_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_header_nav_book_label',
            'label' => 'Book Now Button Label',
            'name' => 'header_nav_book_label',
            'type' => 'text',
        ),

        /* ── Mega Menu Tab ── */
        array(
            'key' => 'field_tab_header_mega',
            'label' => 'Mega Menu',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_header_mega_menu_title',
            'label' => 'Mega Menu Title',
            'name' => 'header_mega_menu_title',
            'type' => 'text',
        ),
        array(
            'key' => 'field_header_mega_menu_desc',
            'label' => 'Mega Menu Description',
            'name' => 'header_mega_menu_desc',
            'type' => 'textarea',
        ),
        array(
            'key' => 'field_header_mega_menu_logo',
            'label' => 'Mega Menu Logo',
            'name' => 'header_mega_menu_logo',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
            'library' => 'all',
        ),
        array(
            'key' => 'field_header_mega_link1_label',
            'label' => 'Mega Link 1 Label',
            'name' => 'header_mega_link1_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_header_mega_link2_label',
            'label' => 'Mega Link 2 Label',
            'name' => 'header_mega_link2_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_header_mega_link3_label',
            'label' => 'Mega Link 3 Label',
            'name' => 'header_mega_link3_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_header_mega_link4_label',
            'label' => 'Mega Link 4 Label',
            'name' => 'header_mega_link4_label',
            'type' => 'text',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-header-settings.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
));

acf_add_local_field_group(array(
    'key' => 'group_footer_settings',
    'title' => 'Footer Settings',
    'fields' => array(

        /* ── Brand Column Tab ── */
        array(
            'key' => 'field_tab_footer_brand',
            'label' => 'Brand Column',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_footer_logo_text',
            'label' => 'Footer Logo Text',
            'name' => 'footer_logo_text',
            'type' => 'text',
        ),
        array(
            'key' => 'field_footer_address',
            'label' => 'Address',
            'name' => 'footer_address',
            'type' => 'textarea',
        ),
        array(
            'key' => 'field_footer_facebook_url',
            'label' => 'Facebook URL',
            'name' => 'footer_facebook_url',
            'type' => 'url',
        ),
        array(
            'key' => 'field_footer_instagram_url',
            'label' => 'Instagram URL',
            'name' => 'footer_instagram_url',
            'type' => 'url',
        ),

        /* ── Company Column Tab ── */
        array(
            'key' => 'field_tab_footer_company',
            'label' => 'Company Column',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_footer_company_title',
            'label' => 'Column Title',
            'name' => 'footer_company_title',
            'type' => 'text',
        ),
        array(
            'key' => 'field_footer_company_link1_label',
            'label' => 'Link 1 Label (About Us)',
            'name' => 'footer_company_link1_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_footer_company_link2_label',
            'label' => 'Link 2 Label (Space Hire)',
            'name' => 'footer_company_link2_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_footer_company_link3_label',
            'label' => 'Link 3 Label (Offshoring Staffing)',
            'name' => 'footer_company_link3_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_footer_company_link4_label',
            'label' => 'Link 4 Label (Shop)',
            'name' => 'footer_company_link4_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_footer_company_link5_label',
            'label' => 'Link 5 Label (Apply)',
            'name' => 'footer_company_link5_label',
            'type' => 'text',
        ),

        /* ── Solutions Column Tab ── */
        array(
            'key' => 'field_tab_footer_solutions',
            'label' => 'Solutions Column',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_footer_solutions_title',
            'label' => 'Column Title',
            'name' => 'footer_solutions_title',
            'type' => 'text',
        ),
        array(
            'key' => 'field_footer_solutions_link1_label',
            'label' => 'Link 1 Label (Why Kings City)',
            'name' => 'footer_solutions_link1_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_footer_solutions_link2_label',
            'label' => 'Link 2 Label (Why Philippines)',
            'name' => 'footer_solutions_link2_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_footer_solutions_link3_label',
            'label' => 'Link 3 Label (Outsourcing Models)',
            'name' => 'footer_solutions_link3_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_footer_solutions_link4_label',
            'label' => 'Link 4 Label (News & Updates)',
            'name' => 'footer_solutions_link4_label',
            'type' => 'text',
        ),

        /* ── Contact Column Tab ── */
        array(
            'key' => 'field_tab_footer_contact',
            'label' => 'Contact Column',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_footer_contact_title',
            'label' => 'Column Title',
            'name' => 'footer_contact_title',
            'type' => 'text',
        ),
        array(
            'key' => 'field_footer_phone',
            'label' => 'Phone Number',
            'name' => 'footer_phone',
            'type' => 'text',
        ),
        array(
            'key' => 'field_footer_email',
            'label' => 'Email Address',
            'name' => 'footer_email',
            'type' => 'text',
        ),

        /* ── Bottom Bar Tab ── */
        array(
            'key' => 'field_tab_footer_bottom',
            'label' => 'Bottom Bar',
            'type' => 'tab',
            'placement' => 'top',
            'endpoint' => 0,
        ),
        array(
            'key' => 'field_footer_copyright',
            'label' => 'Copyright Text',
            'name' => 'footer_copyright',
            'type' => 'text',
        ),
        array(
            'key' => 'field_footer_privacy_label',
            'label' => 'Privacy Policy Label',
            'name' => 'footer_privacy_label',
            'type' => 'text',
        ),
        array(
            'key' => 'field_footer_terms_label',
            'label' => 'Terms of Use Label',
            'name' => 'footer_terms_label',
            'type' => 'text',
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-footer-settings.php',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'active' => true,
));

endif;
?>
