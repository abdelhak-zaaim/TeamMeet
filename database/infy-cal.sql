-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 26, 2024 at 04:22 AM
-- Server version: 8.3.0
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `infy_cal`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint UNSIGNED NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `currency_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_icon` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `currency_name`, `currency_icon`, `currency_code`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'India Rupee', '₹', 'INR', 1, '2024-07-25 22:52:39', '2024-07-25 22:52:39'),
(2, 'USA Dollar', '$', 'USD', 1, '2024-07-25 22:52:39', '2024-07-25 22:52:39'),
(3, 'Australia Dollar', '$', 'AUD', 1, '2024-07-25 22:52:39', '2024-07-25 22:52:39'),
(4, 'Japanese Yen', '¥', 'JPY', 1, '2024-07-25 22:52:39', '2024-07-25 22:52:39'),
(5, 'British Pound', '£', 'GBP', 1, '2024-07-25 22:52:39', '2024-07-25 22:52:39'),
(6, 'Canadian Dollar', '$', 'CAD', 1, '2024-07-25 22:52:39', '2024-07-25 22:52:39');

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `view` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_location` int UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `event_link` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_color` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_meta` text COLLATE utf8mb4_unicode_ci,
  `schedule_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `slot_time` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '30',
  `gap_slot` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_event_per_day` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secret_event` tinyint(1) NOT NULL DEFAULT '0',
  `schedule_days` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '60',
  `schedule_from` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule_to` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_range` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `event_type` int UNSIGNED DEFAULT NULL,
  `payable_amount` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_google_calendars`
--

CREATE TABLE `event_google_calendars` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `google_calendar_list_id` bigint UNSIGNED NOT NULL,
  `google_calendar_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_schedules`
--

CREATE TABLE `event_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED NOT NULL,
  `event_id` bigint UNSIGNED DEFAULT NULL,
  `user_schedule_id` int UNSIGNED DEFAULT NULL,
  `status` int DEFAULT NULL,
  `slot_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` int DEFAULT NULL,
  `cancel_reason` text COLLATE utf8mb4_unicode_ci,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reminder_sent` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'How does the free trial work?', 'It\'s free to use for your first five ticket sales. Once your sixth ticket purchase comes through we will start charging the standard PAY rate. If you would like to move to Pre pay then head to \"Billing\" and \"Buy ticket credits\".', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(2, 'How do you weigh different criteria in your process?', 'That\'s right. We want to make Ticket Tailor as affordable as possible for event organisers of all sizes. You also have the option to pass on any ticketing costs to your customers through a booking fee. We always aim to be the best value on the market so please let us know if you think you can find a similar product for a lower price.', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(3, 'What does First Round look for in an idea?', 'Yes, you can add any booking fee you like to the ticket price, which means all your fees are covered and you get to keep the entire face value of the ticket price. You\'re in total control.', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(4, 'What do you look for in a founding team?', 'All the subscriptions of that plan will retain to stay unless we explicitly move them to any other plan. The deletion is best a \"soft\" delete that stops the plan from permitting new subscriptions.', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(5, 'Do you recommend Pay as you go or Pre pay?', 'If your event has free tickets then there is no charge to use the platform. If your event has paid for tickets then you can get your customer to absorb the fees via the booking fee - in this instance you will receive the face value of the ticket. Please note that all tickets (free and paid) sold using seating charts will incur a fee.', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(6, 'Can I pass the fees on to my customers?', 'We endeavor towards zero downtime, including deployments over weekends. Our development team has broad experience taking care of server versatility and you can lay guaranteed on our capacity to give a very accessible and exceedingly versatile administration. You can check the uptime status of ChargeMonk here.', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(7, 'How do I get paid for the tickets sold?', 'As a dealer, you are as yet in charge of chargebacks as the vendor account is possessed by you. ChargeMonk causes you with the correct apparatuses to convey regularly & impart unambiguously to keep away from chargebacks from your customers. Here are some extra resources on how to avoid chargebacks.', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_settings`
--

CREATE TABLE `front_cms_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `front_cms_settings`
--

INSERT INTO `front_cms_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'front_image', 'front/images/hero-image.png', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(2, 'title', 'Great ticketing system for your customer.', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(3, 'email', 'companyinfo@mail.com', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(4, 'phone', '761 412 3224', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(5, 'region_code', '91', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(6, 'address', 'C-303, Atlanta Shopping Mall, Nr. Sudama Chowk, Mota Varachha, Surat, Gujarat, India.', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(7, 'facebook_url', 'https://www.facebook.com', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(8, 'twitter_url', 'https://www.twitter.com', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(9, 'instagram_url', 'https://www.instagram.com/infyomtechnologies/?hl=en', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(10, 'description', 'For hassale free event, we are here to help you by creating online ticket.', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(11, 'about_us_title', 'The world’s first Conversational Relationship Platform', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(12, 'about_us_description', 'We created Help deski for businesses that share our passion for doing right by the customer. For many of us, great customer service isn’t a cost center — it’s an effective marketing tool, a competitive differentiator, and a cornerstone of the brand.\n<br>\nBut in 2008, there were no customer service platforms available that embodied our customer-centric values. There were help desks that quite literally treated each person like a number and made it far too difficult to build a long-term relationship. We felt a strong pull to make something different, and we did.\n', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(13, 'terms_conditions', '<h1>Terms and Conditions</h1>\n<p>Last updated: December 28, 2021</p>\n<p>Please read these terms and conditions carefully before using Our Service.</p>\n<h1>Interpretation and Definitions</h1>\n<h2>Interpretation</h2>\n<p>The words of which the initial letter is capitalized have meanings defined under the following conditions. The\n    following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</p>\n<h2>Definitions</h2>\n<p>For the purposes of these Terms and Conditions:</p>\n<ul>\n    <li>\n        <p><strong>Affiliate</strong> means an entity that controls, is controlled by or is under common control with a\n            party, where &quot;control&quot; means ownership of 50% or more of the shares, equity interest or other\n            securities entitled to vote for election of directors or other managing authority.</p>\n    </li>\n    <li>\n        <p><strong>Country</strong> refers to: Gujarat, India</p>\n    </li>\n    <li>\n        <p><strong>Company</strong> (referred to as either &quot;the Company&quot;, &quot;We&quot;, &quot;Us&quot; or\n            &quot;Our&quot; in this Agreement) refers to My Site.</p>\n    </li>\n    <li>\n        <p><strong>Device</strong> means any device that can access the Service such as a computer, a cellphone or a\n            digital tablet.</p>\n    </li>\n    <li>\n        <p><strong>Service</strong> refers to the Website.</p>\n    </li>\n    <li>\n        <p><strong>Terms and Conditions</strong> (also referred as &quot;Terms&quot;) mean these Terms and Conditions\n            that form the entire agreement between You and the Company regarding the use of the Service.</p>\n    </li>\n    <li>\n        <p><strong>Third-party Social Media Service</strong> means any services or content (including data, information,\n            products or services) provided by a third-party that may be displayed, included or made available by the\n            Service.</p>\n    </li>\n    <li>\n        <p><strong>Website</strong> refers to My Site, accessible from <a href=\"http://localhost\"\n                                                                          rel=\"external nofollow noopener\"\n                                                                          target=\"_blank\">http://localhost</a></p>\n    </li>\n    <li>\n        <p><strong>You</strong> means the individual accessing or using the Service, or the company, or other legal\n            entity on behalf of which such individual is accessing or using the Service, as applicable.</p>\n    </li>\n</ul>\n<h1>Acknowledgment</h1>\n<p>These are the Terms and Conditions governing the use of this Service and the agreement that operates between You and\n    the Company. These Terms and Conditions set out the rights and obligations of all users regarding the use of the\n    Service.</p>\n<p>Your access to and use of the Service is conditioned on Your acceptance of and compliance with these Terms and\n    Conditions. These Terms and Conditions apply to all visitors, users and others who access or use the Service.</p>\n<p>By accessing or using the Service You agree to be bound by these Terms and Conditions. If You disagree with any part\n    of these Terms and Conditions then You may not access the Service.</p>\n<p>You represent that you are over the age of 18. The Company does not permit those under 18 to use the Service.</p>\n<p>Your access to and use of the Service is also conditioned on Your acceptance of and compliance with the Privacy\n    Policy of the Company. Our Privacy Policy describes Our policies and procedures on the collection, use and\n    disclosure of Your personal information when You use the Application or the Website and tells You about Your privacy\n    rights and how the law protects You. Please read Our Privacy Policy carefully before using Our Service.</p>\n<h1>Links to Other Websites</h1>\n<p>Our Service may contain links to third-party web sites or services that are not owned or controlled by the\n    Company.</p>\n<p>The Company has no control over, and assumes no responsibility for, the content, privacy policies, or practices of\n    any third party web sites or services. You further acknowledge and agree that the Company shall not be responsible\n    or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with\n    the use of or reliance on any such content, goods or services available on or through any such web sites or\n    services.</p>\n<p>We strongly advise You to read the terms and conditions and privacy policies of any third-party web sites or services\n    that You visit.</p>\n<h1>Termination</h1>\n<p>We may terminate or suspend Your access immediately, without prior notice or liability, for any reason whatsoever,\n    including without limitation if You breach these Terms and Conditions.</p>\n<p>Upon termination, Your right to use the Service will cease immediately.</p>\n<h1>Limitation of Liability</h1>\n<p>Notwithstanding any damages that You might incur, the entire liability of the Company and any of its suppliers under\n    any provision of this Terms and Your exclusive remedy for all of the foregoing shall be limited to the amount\n    actually paid by You through the Service or 100 USD if You haven\'t purchased anything through the Service.</p>\n<p>To the maximum extent permitted by applicable law, in no event shall the Company or its suppliers be liable for any\n    special, incidental, indirect, or consequential damages whatsoever (including, but not limited to, damages for loss\n    of profits, loss of data or other information, for business interruption, for personal injury, loss of privacy\n    arising out of or in any way related to the use of or inability to use the Service, third-party software and/or\n    third-party hardware used with the Service, or otherwise in connection with any provision of this Terms), even if\n    the Company or any supplier has been advised of the possibility of such damages and even if the remedy fails of its\n    essential purpose.</p>\n<p>Some states do not allow the exclusion of implied warranties or limitation of liability for incidental or\n    consequential damages, which means that some of the above limitations may not apply. In these states, each party\'s\n    liability will be limited to the greatest extent permitted by law.</p>\n<h1>&quot;AS IS&quot; and &quot;AS AVAILABLE&quot; Disclaimer</h1>\n<p>The Service is provided to You &quot;AS IS&quot; and &quot;AS AVAILABLE&quot; and with all faults and defects without\n    warranty of any kind. To the maximum extent permitted under applicable law, the Company, on its own behalf and on\n    behalf of its Affiliates and its and their respective licensors and service providers, expressly disclaims all\n    warranties, whether express, implied, statutory or otherwise, with respect to the Service, including all implied\n    warranties of merchantability, fitness for a particular purpose, title and non-infringement, and warranties that may\n    arise out of course of dealing, course of performance, usage or trade practice. Without limitation to the foregoing,\n    the Company provides no warranty or undertaking, and makes no representation of any kind that the Service will meet\n    Your requirements, achieve any intended results, be compatible or work with any other software, applications,\n    systems or services, operate without interruption, meet any performance or reliability standards or be error free or\n    that any errors or defects can or will be corrected.</p>\n<p>Without limiting the foregoing, neither the Company nor any of the company\'s provider makes any representation or\n    warranty of any kind, express or implied: (i) as to the operation or availability of the Service, or the\n    information, content, and materials or products included thereon; (ii) that the Service will be uninterrupted or\n    error-free; (iii) as to the accuracy, reliability, or currency of any information or content provided through the\n    Service; or (iv) that the Service, its servers, the content, or e-mails sent from or on behalf of the Company are\n    free of viruses, scripts, trojan horses, worms, malware, timebombs or other harmful components.</p>\n<p>Some jurisdictions do not allow the exclusion of certain types of warranties or limitations on applicable statutory\n    rights of a consumer, so some or all of the above exclusions and limitations may not apply to You. But in such a\n    case the exclusions and limitations set forth in this section shall be applied to the greatest extent enforceable\n    under applicable law.</p>\n<h1>Governing Law</h1>\n<p>The laws of the Country, excluding its conflicts of law rules, shall govern this Terms and Your use of the Service.\n    Your use of the Application may also be subject to other local, state, national, or international laws.</p>\n<h1>Disputes Resolution</h1>\n<p>If You have any concern or dispute about the Service, You agree to first try to resolve the dispute informally by\n    contacting the Company.</p>\n<h1>For European Union (EU) Users</h1>\n<p>If You are a European Union consumer, you will benefit from any mandatory provisions of the law of the country in\n    which you are resident in.</p>\n<h1>United States Legal Compliance</h1>\n<p>You represent and warrant that (i) You are not located in a country that is subject to the United States government\n    embargo, or that has been designated by the United States government as a &quot;terrorist supporting&quot; country,\n    and (ii) You are not listed on any United States government list of prohibited or restricted parties.</p>\n<h1>Severability and Waiver</h1>\n<h2>Severability</h2>\n<p>If any provision of these Terms is held to be unenforceable or invalid, such provision will be changed and\n    interpreted to accomplish the objectives of such provision to the greatest extent possible under applicable law and\n    the remaining provisions will continue in full force and effect.</p>\n<h2>Waiver</h2>\n<p>Except as provided herein, the failure to exercise a right or to require performance of an obligation under this\n    Terms shall not effect a party\'s ability to exercise such right or require such performance at any time thereafter\n    nor shall be the waiver of a breach constitute a waiver of any subsequent breach.</p>\n<h1>Translation Interpretation</h1>\n<p>These Terms and Conditions may have been translated if We have made them available to You on our Service.\n    You agree that the original English text shall prevail in the case of a dispute.</p>\n<h1>Changes to These Terms and Conditions</h1>\n<p>We reserve the right, at Our sole discretion, to modify or replace these Terms at any time. If a revision is material\n    We will make reasonable efforts to provide at least 30 days\' notice prior to any new terms taking effect. What\n    constitutes a material change will be determined at Our sole discretion.</p>\n<p>By continuing to access or use Our Service after those revisions become effective, You agree to be bound by the\n    revised terms. If You do not agree to the new terms, in whole or in part, please stop using the website and the\n    Service.</p>\n<h1>Contact Us</h1>\n<p>If you have any questions about these Terms and Conditions, You can contact us:</p>\n\n', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(14, 'privacy_policy', '<h1>Privacy Policy</h1>\n<p>Last updated: December 28, 2021</p>\n<p>This Privacy Policy describes Our policies and procedures on the collection, use and disclosure of Your information\n    when You use the Service and tells You about Your privacy rights and how the law protects You.</p>\n<p>We use Your Personal data to provide and improve the Service. By using the Service, You agree to the collection and\n    use of information in accordance with this Privacy Policy.</p>\n<h1>Interpretation and Definitions</h1>\n<h2>Interpretation</h2>\n<p>The words of which the initial letter is capitalized have meanings defined under the following conditions. The\n    following definitions shall have the same meaning regardless of whether they appear in singular or in plural.</p>\n<h2>Definitions</h2>\n<p>For the purposes of this Privacy Policy:</p>\n<ul>\n    <li>\n        <p><strong>Account</strong> means a unique account created for You to access our Service or parts of our\n            Service.</p>\n    </li>\n    <li>\n        <p><strong>Company</strong> (referred to as either &quot;the Company&quot;, &quot;We&quot;, &quot;Us&quot; or\n            &quot;Our&quot; in this Agreement) refers to My Site.</p>\n    </li>\n    <li>\n        <p><strong>Cookies</strong> are small files that are placed on Your computer, mobile device or any other device\n            by a website, containing the details of Your browsing history on that website among its many uses.</p>\n    </li>\n    <li>\n        <p><strong>Country</strong> refers to: Gujarat, India</p>\n    </li>\n    <li>\n        <p><strong>Device</strong> means any device that can access the Service such as a computer, a cellphone or a\n            digital tablet.</p>\n    </li>\n    <li>\n        <p><strong>Personal Data</strong> is any information that relates to an identified or identifiable individual.\n        </p>\n    </li>\n    <li>\n        <p><strong>Service</strong> refers to the Website.</p>\n    </li>\n    <li>\n        <p><strong>Service Provider</strong> means any natural or legal person who processes the data on behalf of the\n            Company. It refers to third-party companies or individuals employed by the Company to facilitate the\n            Service, to provide the Service on behalf of the Company, to perform services related to the Service or to\n            assist the Company in analyzing how the Service is used.</p>\n    </li>\n    <li>\n        <p><strong>Usage Data</strong> refers to data collected automatically, either generated by the use of the\n            Service or from the Service infrastructure itself (for example, the duration of a page visit).</p>\n    </li>\n    <li>\n        <p><strong>Website</strong> refers to My Site, accessible from <a href=\"http://localhost\"\n                                                                          rel=\"external nofollow noopener\"\n                                                                          target=\"_blank\">http://localhost</a></p>\n    </li>\n    <li>\n        <p><strong>You</strong> means the individual accessing or using the Service, or the company, or other legal\n            entity on behalf of which such individual is accessing or using the Service, as applicable.</p>\n    </li>\n</ul>\n<h1>Collecting and Using Your Personal Data</h1>\n<h2>Types of Data Collected</h2>\n<h3>Personal Data</h3>\n<p>While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be\n    used to contact or identify You. Personally identifiable information may include, but is not limited to:</p>\n<ul>\n    <li>\n        <p>Email address</p>\n    </li>\n    <li>\n        <p>First name and last name</p>\n    </li>\n    <li>\n        <p>Phone number</p>\n    </li>\n    <li>\n        <p>Usage Data</p>\n    </li>\n</ul>\n<h3>Usage Data</h3>\n<p>Usage Data is collected automatically when using the Service.</p>\n<p>Usage Data may include information such as Your Device\'s Internet Protocol address (e.g. IP address), browser type,\n    browser version, the pages of our Service that You visit, the time and date of Your visit, the time spent on those\n    pages, unique device identifiers and other diagnostic data.</p>\n<p>When You access the Service by or through a mobile device, We may collect certain information automatically,\n    including, but not limited to, the type of mobile device You use, Your mobile device unique ID, the IP address of\n    Your mobile device, Your mobile operating system, the type of mobile Internet browser You use, unique device\n    identifiers and other diagnostic data.</p>\n<p>We may also collect information that Your browser sends whenever You visit our Service or when You access the Service\n    by or through a mobile device.</p>\n<h3>Tracking Technologies and Cookies</h3>\n<p>We use Cookies and similar tracking technologies to track the activity on Our Service and store certain information.\n    Tracking technologies used are beacons, tags, and scripts to collect and track information and to improve and\n    analyze Our Service. The technologies We use may include:</p>\n<ul>\n    <li><strong>Cookies or Browser Cookies.</strong> A cookie is a small file placed on Your Device. You can instruct\n        Your browser to refuse all Cookies or to indicate when a Cookie is being sent. However, if You do not accept\n        Cookies, You may not be able to use some parts of our Service. Unless you have adjusted Your browser setting so\n        that it will refuse Cookies, our Service may use Cookies.\n    </li>\n    <li><strong>Flash Cookies.</strong> Certain features of our Service may use local stored objects (or Flash Cookies)\n        to collect and store information about Your preferences or Your activity on our Service. Flash Cookies are not\n        managed by the same browser settings as those used for Browser Cookies. For more information on how You can\n        delete Flash Cookies, please read &quot;Where can I change the settings for disabling, or deleting local shared\n        objects?&quot; available at <a\n                href=\"//helpx.adobe.com/flash-player/kb/disable-local-shared-objects-flash.html#main_Where_can_I_change_the_settings_for_disabling__or_deleting_local_shared_objects_\"\n                rel=\"external nofollow noopener\" target=\"_blank\">Link</a>\n    </li>\n    <li><strong>Web Beacons.</strong> Certain sections of our Service and our emails may contain small electronic files\n        known as web beacons (also referred to as clear gifs, pixel tags, and single-pixel gifs) that permit the\n        Company, for example, to count users who have visited those pages or opened an email and for other related\n        website statistics (for example, recording the popularity of a certain section and verifying system and server\n        integrity).\n    </li>\n</ul>\n<p>Cookies can be &quot;Persistent&quot; or &quot;Session&quot; Cookies. Persistent Cookies remain on Your personal\n    computer or mobile device when You go offline, while Session Cookies are deleted as soon as You close Your web\n    browser. You can learn more about cookies here: <a href=\"//html.com/resources/cookies-ultimate-guide/\"\n                                                       target=\"_blank\">Cookies Ultimate Guide</a>.</p>\n<p>We use both Session and Persistent Cookies for the purposes set out below:</p>\n<ul>\n    <li>\n        <p><strong>Necessary / Essential Cookies</strong></p>\n        <p>Type: Session Cookies</p>\n        <p>Administered by: Us</p>\n        <p>Purpose: These Cookies are essential to provide You with services available through the Website and to enable\n            You to use some of its features. They help to authenticate users and prevent fraudulent use of user\n            accounts. Without these Cookies, the services that You have asked for cannot be provided, and We only use\n            these Cookies to provide You with those services.</p>\n    </li>\n    <li>\n        <p><strong>Cookies Policy / Notice Acceptance Cookies</strong></p>\n        <p>Type: Persistent Cookies</p>\n        <p>Administered by: Us</p>\n        <p>Purpose: These Cookies identify if users have accepted the use of cookies on the Website.</p>\n    </li>\n    <li>\n        <p><strong>Functionality Cookies</strong></p>\n        <p>Type: Persistent Cookies</p>\n        <p>Administered by: Us</p>\n        <p>Purpose: These Cookies allow us to remember choices You make when You use the Website, such as remembering\n            your login details or language preference. The purpose of these Cookies is to provide You with a more\n            personal experience and to avoid You having to re-enter your preferences every time You use the Website.</p>\n    </li>\n</ul>\n<p>For more information about the cookies we use and your choices regarding cookies, please visit our Cookies Policy or\n    the Cookies section of our Privacy Policy.</p>\n<h2>Use of Your Personal Data</h2>\n<p>The Company may use Personal Data for the following purposes:</p>\n<ul>\n    <li>\n        <p><strong>To provide and maintain our Service</strong>, including to monitor the usage of our Service.</p>\n    </li>\n    <li>\n        <p><strong>To manage Your Account:</strong> to manage Your registration as a user of the Service. The Personal\n            Data You provide can give You access to different functionalities of the Service that are available to You\n            as a registered user.</p>\n    </li>\n    <li>\n        <p><strong>For the performance of a contract:</strong> the development, compliance and undertaking of the\n            purchase contract for the products, items or services You have purchased or of any other contract with Us\n            through the Service.</p>\n    </li>\n    <li>\n        <p><strong>To contact You:</strong> To contact You by email, telephone calls, SMS, or other equivalent forms of\n            electronic communication, such as a mobile application\'s push notifications regarding updates or informative\n            communications related to the functionalities, products or contracted services, including the security\n            updates, when necessary or reasonable for their implementation.</p>\n    </li>\n    <li>\n        <p><strong>To provide You</strong> with news, special offers and general information about other goods, services\n            and events which we offer that are similar to those that you have already purchased or enquired about unless\n            You have opted not to receive such information.</p>\n    </li>\n    <li>\n        <p><strong>To manage Your requests:</strong> To attend and manage Your requests to Us.</p>\n    </li>\n    <li>\n        <p><strong>For business transfers:</strong> We may use Your information to evaluate or conduct a merger,\n            divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some or all of Our\n            assets, whether as a going concern or as part of bankruptcy, liquidation, or similar proceeding, in which\n            Personal Data held by Us about our Service users is among the assets transferred.</p>\n    </li>\n    <li>\n        <p><strong>For other purposes</strong>: We may use Your information for other purposes, such as data analysis,\n            identifying usage trends, determining the effectiveness of our promotional campaigns and to evaluate and\n            improve our Service, products, services, marketing and your experience.</p>\n    </li>\n</ul>\n<p>We may share Your personal information in the following situations:</p>\n<ul>\n    <li><strong>With Service Providers:</strong> We may share Your personal information with Service Providers to\n        monitor and analyze the use of our Service, to contact You.\n    </li>\n    <li><strong>For business transfers:</strong> We may share or transfer Your personal information in connection with,\n        or during negotiations of, any merger, sale of Company assets, financing, or acquisition of all or a portion of\n        Our business to another company.\n    </li>\n    <li><strong>With Affiliates:</strong> We may share Your information with Our affiliates, in which case we will\n        require those affiliates to honor this Privacy Policy. Affiliates include Our parent company and any other\n        subsidiaries, joint venture partners or other companies that We control or that are under common control with\n        Us.\n    </li>\n    <li><strong>With business partners:</strong> We may share Your information with Our business partners to offer You\n        certain products, services or promotions.\n    </li>\n    <li><strong>With other users:</strong> when You share personal information or otherwise interact in the public areas\n        with other users, such information may be viewed by all users and may be publicly distributed outside.\n    </li>\n    <li><strong>With Your consent</strong>: We may disclose Your personal information for any other purpose with Your\n        consent.\n    </li>\n</ul>\n<h2>Retention of Your Personal Data</h2>\n<p>The Company will retain Your Personal Data only for as long as is necessary for the purposes set out in this Privacy\n    Policy. We will retain and use Your Personal Data to the extent necessary to comply with our legal obligations (for\n    example, if we are required to retain your data to comply with applicable laws), resolve disputes, and enforce our\n    legal agreements and policies.</p>\n<p>The Company will also retain Usage Data for internal analysis purposes. Usage Data is generally retained for a\n    shorter period of time, except when this data is used to strengthen the security or to improve the functionality of\n    Our Service, or We are legally obligated to retain this data for longer time periods.</p>\n<h2>Transfer of Your Personal Data</h2>\n<p>Your information, including Personal Data, is processed at the Company\'s operating offices and in any other places\n    where the parties involved in the processing are located. It means that this information may be transferred to — and\n    maintained on — computers located outside of Your state, province, country or other governmental jurisdiction where\n    the data protection laws may differ than those from Your jurisdiction.</p>\n<p>Your consent to this Privacy Policy followed by Your submission of such information represents Your agreement to that\n    transfer.</p>\n<p>The Company will take all steps reasonably necessary to ensure that Your data is treated securely and in accordance\n    with this Privacy Policy and no transfer of Your Personal Data will take place to an organization or a country\n    unless there are adequate controls in place including the security of Your data and other personal information.</p>\n<h2>Disclosure of Your Personal Data</h2>\n<h3>Business Transactions</h3>\n<p>If the Company is involved in a merger, acquisition or asset sale, Your Personal Data may be transferred. We will\n    provide notice before Your Personal Data is transferred and becomes subject to a different Privacy Policy.</p>\n<h3>Law enforcement</h3>\n<p>Under certain circumstances, the Company may be required to disclose Your Personal Data if required to do so by law\n    or in response to valid requests by public authorities (e.g. a court or a government agency).</p>\n<h3>Other legal requirements</h3>\n<p>The Company may disclose Your Personal Data in the good faith belief that such action is necessary to:</p>\n<ul>\n    <li>Comply with a legal obligation</li>\n    <li>Protect and defend the rights or property of the Company</li>\n    <li>Prevent or investigate possible wrongdoing in connection with the Service</li>\n    <li>Protect the personal safety of Users of the Service or the public</li>\n    <li>Protect against legal liability</li>\n</ul>\n<h2>Security of Your Personal Data</h2>\n<p>The security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet,\n    or method of electronic storage is 100% secure. While We strive to use commercially acceptable means to protect Your\n    Personal Data, We cannot guarantee its absolute security.</p>\n<h1>Children\'s Privacy</h1>\n<p>Our Service does not address anyone under the age of 13. We do not knowingly collect personally identifiable\n    information from anyone under the age of 13. If You are a parent or guardian and You are aware that Your child has\n    provided Us with Personal Data, please contact Us. If We become aware that We have collected Personal Data from\n    anyone under the age of 13 without verification of parental consent, We take steps to remove that information from\n    Our servers.</p>\n<p>If We need to rely on consent as a legal basis for processing Your information and Your country requires consent from\n    a parent, We may require Your parent\'s consent before We collect and use that information.</p>\n<h1>Links to Other Websites</h1>\n<p>Our Service may contain links to other websites that are not operated by Us. If You click on a third party link, You\n    will be directed to that third party\'s site. We strongly advise You to review the Privacy Policy of every site You\n    visit.</p>\n<p>We have no control over and assume no responsibility for the content, privacy policies or practices of any third\n    party sites or services.</p>\n<h1>Changes to this Privacy Policy</h1>\n<p>We may update Our Privacy Policy from time to time. We will notify You of any changes by posting the new Privacy\n    Policy on this page.</p>\n<p>We will let You know via email and/or a prominent notice on Our Service, prior to the change becoming effective and\n    update the &quot;Last updated&quot; date at the top of this Privacy Policy.</p>\n<p>You are advised to review this Privacy Policy periodically for any changes. Changes to this Privacy Policy are\n    effective when they are posted on this page.</p>\n<h1>Contact Us</h1>\n<p>If you have any questions about this Privacy Policy, You can contact us:</p>\n', '2024-07-25 22:52:40', '2024-07-25 22:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `front_testimonials`
--

CREATE TABLE `front_testimonials` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `front_testimonials`
--

INSERT INTO `front_testimonials` (`id`, `name`, `designation`, `short_description`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Rashed kabir', 'Designer', 'Having a home based business is a wonderful asset to your life. The problem still stands it comes time advertise your business for a cheap cost. I know you have looked answer everywhere.', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(2, 'Zubayer Hasan', 'Designer', 'Having a home based business is a wonderful asset to your life. The problem still stands it comes time advertise your business for a cheap cost. I know you have looked answer everywhere.', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `google_calendar_integrations`
--

CREATE TABLE `google_calendar_integrations` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `access_token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_used_at` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `google_calendar_lists`
--

CREATE TABLE `google_calendar_lists` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `calendar_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_calendar_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `main_reasons`
--

CREATE TABLE `main_reasons` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_reasons`
--

INSERT INTO `main_reasons` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'main_title', '3 Main Reason to Choose us.', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(2, 'image', 'front/images/schedule-concept.jpg', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(3, 'title_1', 'Register and create your first support portal', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(4, 'description_1', 'It only takes 5 minutes. Set-up is smooth & simple, with fully customisable page design to reflect your brand lorem dummy.', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(5, 'title_2', 'Manage your dashboard easily', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(6, 'description_2', 'It only takes 5 minutes. Set-up is smooth & simple, with fully customisable page design to reflect your brand lorem dummy.', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(7, 'title_3', 'Start giving support', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(8, 'description_3', 'It only takes 5 minutes. Set-up is smooth & simple, with fully customisable page design to reflect your brand lorem dummy.', '2024-07-25 22:52:40', '2024-07-25 22:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(160) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `manipulations` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_properties` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `generated_conversions` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsive_images` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_column` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2021_07_26_044558_create_media_table', 1),
(4, '2021_07_28_114939_create_settings_table', 1),
(5, '2021_08_05_085326_create_permission_tables', 1),
(6, '2021_10_11_104401_create_personal_experiences_table', 1),
(7, '2021_10_12_000000_create_users_table', 1),
(8, '2021_10_12_065324_create_schedules_table', 1),
(9, '2021_10_13_064755_create_events_table', 1),
(10, '2021_10_13_110528_create_user_schedules_table', 1),
(11, '2021_11_16_100158_create_event_schedules_table', 1),
(12, '2021_12_07_074300_create_transactions_table', 1),
(13, '2021_12_15_064117_create_subscription_plans_table', 1),
(14, '2021_12_15_124324_add_uuid_field_in_event_schedules_table', 1),
(15, '2021_12_16_050413_change_personal_experiences_table_field', 1),
(16, '2021_12_18_075853_add_otp_field_in_event_schedules_table', 1),
(17, '2021_12_23_112005_create_front_testimonials_table', 1),
(18, '2021_12_24_063758_create_front_cms_settings_table', 1),
(19, '2021_12_24_072717_create_brands_table', 1),
(20, '2021_12_24_120956_create_services_table', 1),
(21, '2021_12_25_054631_create_main_reasons_table', 1),
(22, '2021_12_25_072213_create_enquiries_table', 1),
(23, '2021_12_27_125140_create_faqs_table', 1),
(24, '2021_12_30_044106_create_subscribes_table', 1),
(25, '2022_01_03_045342_change_email_unique_in_enquiries_table', 1),
(26, '2022_01_03_045342_change_email_unique_in_event_schedules_table', 1),
(27, '2022_01_04_063636_create_user_transactions_table', 1),
(28, '2022_01_05_073335_create_subscriptions_table', 1),
(29, '2022_01_05_083355_add_payment_type_field_in_event_schedules_table', 1),
(30, '2022_01_07_094107_add_is_custom_field_in_schedules_table', 1),
(31, '2022_01_10_062840_create_subscription_plans_features_table', 1),
(32, '2022_01_21_045233_add_check_tab_field_in_user_schedules_table', 1),
(33, '2022_01_24_130438_change_field_in_failed_jobs_table', 1),
(34, '2022_01_24_130557_change_field_in_media_table', 1),
(35, '2022_01_24_130755_change_field_in_model_has_permissions_table', 1),
(36, '2022_01_24_130755_change_field_in_model_has_role_table', 1),
(37, '2022_01_24_130755_change_field_in_password_resets_table', 1),
(38, '2022_01_24_130755_change_field_in_permissions_table', 1),
(39, '2022_01_24_130755_change_field_in_roles_table', 1),
(40, '2022_01_24_130755_change_field_in_subscribes_table', 1),
(41, '2022_01_24_130755_change_field_in_user_transactions_table', 1),
(42, '2022_01_24_130755_change_field_in_users_table', 1),
(43, '2022_01_26_103518_add_check_default_field_in_user_schedules_table', 1),
(44, '2022_02_01_140622_create_user_settings_table', 1),
(45, '2022_02_07_123050_change_field_nullable_in_settings_table', 1),
(46, '2022_05_10_123950_create_google_calendar_lists_table', 1),
(47, '2022_05_10_124139_create_google_calendar_integrations_table', 1),
(48, '2022_05_11_114825_create_event_google_calendars_table', 1),
(49, '2022_05_12_084217_create_user_google_event_schedules', 1),
(50, '2022_05_13_094146_change_location_meta_field_type_in_events_table', 1),
(51, '2022_07_07_105940_change_question_field_type_in_faqs_table', 1),
(52, '2022_07_21_132820_change_access_token_field_type_in_google_calendar_integrations_table', 1),
(53, '2022_09_13_045616_run_default_country_code_seeder', 1),
(54, '2022_10_07_101310_add_is_super_admin_field_in_users_table', 1),
(55, '2022_10_07_101610_run_is_super_admin_default_field_seeder', 1),
(56, '2022_10_07_114609_create_currencies_table', 1),
(57, '2022_10_10_062308_run_default_currencies_seeder_table', 1),
(58, '2022_12_01_090700_add_google_meet_link_field_in_user_google_event_schedules_table', 1),
(59, '2023_03_13_040642_add_two_fields_in_user_transactions_table', 1),
(60, '2023_03_18_060827_add_new_field_into_event_schedule_table', 1),
(61, '2023_09_15_000000_rename_password_resets_table', 1),
(62, '2023_12_11_065106_run_default_credentials_seeder', 1),
(63, '2024_02_21_113744_create_jobs_table', 1),
(64, '2024_04_01_084509_create_paystack_seeder_table', 1),
(65, '2024_06_03_060518_add_google_captcha_at_super_admin_setting', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_experiences`
--

CREATE TABLE `personal_experiences` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_experiences`
--

INSERT INTO `personal_experiences` (`id`, `name`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Leader + Entrepreneur', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(2, 'Customer success + Account Management', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(3, 'Education', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(4, 'Freelance + Consultant', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(5, 'Interview Scheduling', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(6, 'Sales + Marketing', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(7, 'Other', 1, '2024-07-25 22:52:40', '2024-07-25 22:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `is_default`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', 1, 'web', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(2, 'user', 'User', 1, 'web', '2024-07-25 22:52:40', '2024-07-25 22:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `schedule_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_custom` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'main_title', 'Use deski to drive growth at your business.', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(2, 'service_image_1', 'front/images/smart-popups.png', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(3, 'service_image_2', 'front/images/embeded-forms.png', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(4, 'service_image_3', 'front/images/autoresponder.png', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(5, 'service_title_1', 'Smart popups', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(6, 'service_title_2', 'Embeded Forms', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(7, 'service_title_3', 'Autoresponder', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(8, 'service_description_1', 'Create customized popups and show the right message at the right time. lorem dummy.', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(9, 'service_description_2', 'Collect website leads with embedded forms and integrate easily.', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(10, 'service_description_3', 'Send welcome email to your new subscribers with a code.', '2024-07-25 22:52:40', '2024-07-25 22:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'default_country_code', 'in', '2024-07-25 22:52:39', '2024-07-25 22:52:39'),
(2, 'stripe_checkbox_btn', '0', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(3, 'stripe_key', '', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(4, 'stripe_secret', '', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(5, 'paypal_checkbox_btn', '0', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(6, 'paypal_client_id', '', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(7, 'paypal_secret', '', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(8, 'paypal_mode', '', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(9, 'paystack_checkbox_btn', '0', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(10, 'paystack_key', NULL, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(11, 'paystack_secret', NULL, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(12, 'enable_google_recaptcha', '0', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(13, 'google_captcha_key', NULL, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(14, 'google_captcha_secret', NULL, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(15, 'application_name', 'InfyCal', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(16, 'currency', 'inr', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(17, 'logo', 'assets/images/infy-cal-logo.png', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(18, 'favicon', 'assets/images/favicon.ico', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(19, 'plan_expire_notification', '6', '2024-07-25 22:52:41', '2024-07-25 22:52:41'),
(20, 'auto_detect_location_enable', '0', '2024-07-25 22:52:41', '2024-07-25 22:52:41'),
(21, 'google_place_api_key', '', '2024-07-25 22:52:41', '2024-07-25 22:52:41');

-- --------------------------------------------------------

--
-- Table structure for table `subscribes`
--

CREATE TABLE `subscribes` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscribe` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `subscription_plan_id` bigint UNSIGNED DEFAULT NULL,
  `transaction_id` bigint UNSIGNED DEFAULT NULL,
  `plan_amount` double(8,2) DEFAULT '0.00',
  `plan_frequency` int NOT NULL DEFAULT '1' COMMENT '1 = Month, 2 = Year',
  `starts_at` datetime NOT NULL,
  `ends_at` datetime NOT NULL,
  `trial_ends_at` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `id` bigint UNSIGNED NOT NULL,
  `currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'usd',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) DEFAULT '0.00',
  `frequency` int NOT NULL DEFAULT '1' COMMENT '1 = Month, 2 = Year',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `trial_days` int NOT NULL DEFAULT '0' COMMENT 'Default validity will be 7 trial days',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`id`, `currency`, `name`, `price`, `frequency`, `is_default`, `trial_days`, `created_at`, `updated_at`) VALUES
(1, 'usd', 'Standard', 99.00, 1, 1, 7, '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(2, 'usd', 'Basic', 999.00, 2, 0, 30, '2024-07-25 22:52:40', '2024-07-25 22:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans_features`
--

CREATE TABLE `subscription_plans_features` (
  `id` bigint UNSIGNED NOT NULL,
  `subscription_plan_id` bigint UNSIGNED DEFAULT NULL,
  `events` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule_events` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_plans_features`
--

INSERT INTO `subscription_plans_features` (`id`, `subscription_plan_id`, `events`, `schedule_events`, `created_at`, `updated_at`) VALUES
(1, 1, '1', '2', '2024-07-25 22:52:40', '2024-07-25 22:52:40'),
(2, 2, '1', '2', '2024-07-25 22:52:40', '2024-07-25 22:52:40');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `schedule_event_id` bigint UNSIGNED DEFAULT NULL,
  `amount` double NOT NULL,
  `type` int DEFAULT NULL,
  `meta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `is_super_admin` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'en',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` int DEFAULT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domain_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `region_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step` int DEFAULT NULL,
  `personal_experience_id` int UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `status`, `is_super_admin`, `language`, `email_verified_at`, `password`, `gender`, `phone_number`, `domain_url`, `timezone`, `region_code`, `step`, `personal_experience_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super', 'Admin', 'admin@infycal.com', 1, 1, 'en', '2024-07-25 22:52:40', '$2y$10$PJEx/6s9675xS6r/9eDDUO6nfwCUtqgvLz6wlagdtQa.df6TftYEy', NULL, NULL, 'infycal', '160', NULL, 3, NULL, NULL, '2024-07-25 22:52:40', '2024-07-25 22:52:41');

-- --------------------------------------------------------

--
-- Table structure for table `user_google_event_schedules`
--

CREATE TABLE `user_google_event_schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `event_schedule_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_calendar_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_event_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `google_meet_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_schedules`
--

CREATE TABLE `user_schedules` (
  `id` int UNSIGNED NOT NULL,
  `schedule_id` bigint UNSIGNED DEFAULT NULL,
  `event_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `from_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_time` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `day_of_week` int DEFAULT NULL,
  `check_tab` tinyint(1) NOT NULL DEFAULT '0',
  `check_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

CREATE TABLE `user_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_transactions`
--

CREATE TABLE `user_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` int NOT NULL COMMENT '1 = Stripe, 2 = Paypal',
  `amount` double(8,2) NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta` text COLLATE utf8mb4_unicode_ci,
  `subscription_status` int NOT NULL DEFAULT '1',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currencies_currency_name_unique` (`currency_name`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_user_id_foreign` (`user_id`),
  ADD KEY `events_schedule_id_foreign` (`schedule_id`);

--
-- Indexes for table `event_google_calendars`
--
ALTER TABLE `event_google_calendars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_google_calendars_user_id_foreign` (`user_id`),
  ADD KEY `event_google_calendars_google_calendar_list_id_foreign` (`google_calendar_list_id`);

--
-- Indexes for table `event_schedules`
--
ALTER TABLE `event_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_schedules_user_id_foreign` (`user_id`),
  ADD KEY `event_schedules_event_id_foreign` (`event_id`),
  ADD KEY `event_schedules_user_schedule_id_foreign` (`user_schedule_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_cms_settings`
--
ALTER TABLE `front_cms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `front_testimonials`
--
ALTER TABLE `front_testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `google_calendar_integrations`
--
ALTER TABLE `google_calendar_integrations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `google_calendar_integrations_user_id_foreign` (`user_id`);

--
-- Indexes for table `google_calendar_lists`
--
ALTER TABLE `google_calendar_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `google_calendar_lists_user_id_foreign` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `main_reasons`
--
ALTER TABLE `main_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_experiences`
--
ALTER TABLE `personal_experiences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_user_id_foreign` (`user_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribes`
--
ALTER TABLE `subscribes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribes_email_unique` (`email`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscriptions_user_id_index` (`user_id`),
  ADD KEY `subscriptions_subscription_plan_id_index` (`subscription_plan_id`),
  ADD KEY `subscriptions_transaction_id_index` (`transaction_id`),
  ADD KEY `subscriptions_plan_amount_index` (`plan_amount`),
  ADD KEY `subscriptions_plan_frequency_index` (`plan_frequency`),
  ADD KEY `subscriptions_starts_at_index` (`starts_at`),
  ADD KEY `subscriptions_ends_at_index` (`ends_at`),
  ADD KEY `subscriptions_trial_ends_at_index` (`trial_ends_at`),
  ADD KEY `subscriptions_status_index` (`status`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription_plans_features`
--
ALTER TABLE `subscription_plans_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subscription_plans_features_subscription_plan_id_foreign` (`subscription_plan_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_schedule_event_id_foreign` (`schedule_event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_personal_experience_id_foreign` (`personal_experience_id`);

--
-- Indexes for table `user_google_event_schedules`
--
ALTER TABLE `user_google_event_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_google_event_schedules_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_schedules`
--
ALTER TABLE `user_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_schedules_schedule_id_foreign` (`schedule_id`),
  ADD KEY `user_schedules_event_id_foreign` (`event_id`),
  ADD KEY `user_schedules_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_settings_user_id_foreign` (`user_id`);

--
-- Indexes for table `user_transactions`
--
ALTER TABLE `user_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_transactions_transaction_id_index` (`transaction_id`),
  ADD KEY `user_transactions_payment_type_index` (`payment_type`),
  ADD KEY `user_transactions_amount_index` (`amount`),
  ADD KEY `user_transactions_user_id_index` (`user_id`),
  ADD KEY `user_transactions_status_index` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_google_calendars`
--
ALTER TABLE `event_google_calendars`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_schedules`
--
ALTER TABLE `event_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `front_cms_settings`
--
ALTER TABLE `front_cms_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `front_testimonials`
--
ALTER TABLE `front_testimonials`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `google_calendar_integrations`
--
ALTER TABLE `google_calendar_integrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `google_calendar_lists`
--
ALTER TABLE `google_calendar_lists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `main_reasons`
--
ALTER TABLE `main_reasons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_experiences`
--
ALTER TABLE `personal_experiences`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `subscribes`
--
ALTER TABLE `subscribes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscription_plans_features`
--
ALTER TABLE `subscription_plans_features`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_google_event_schedules`
--
ALTER TABLE `user_google_event_schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_schedules`
--
ALTER TABLE `user_schedules`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_settings`
--
ALTER TABLE `user_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_transactions`
--
ALTER TABLE `user_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_google_calendars`
--
ALTER TABLE `event_google_calendars`
  ADD CONSTRAINT `event_google_calendars_google_calendar_list_id_foreign` FOREIGN KEY (`google_calendar_list_id`) REFERENCES `google_calendar_lists` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_google_calendars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_schedules`
--
ALTER TABLE `event_schedules`
  ADD CONSTRAINT `event_schedules_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_schedules_user_schedule_id_foreign` FOREIGN KEY (`user_schedule_id`) REFERENCES `user_schedules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `google_calendar_integrations`
--
ALTER TABLE `google_calendar_integrations`
  ADD CONSTRAINT `google_calendar_integrations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `google_calendar_lists`
--
ALTER TABLE `google_calendar_lists`
  ADD CONSTRAINT `google_calendar_lists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_subscription_plan_id_foreign` FOREIGN KEY (`subscription_plan_id`) REFERENCES `subscription_plans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscriptions_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `user_transactions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscriptions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subscription_plans_features`
--
ALTER TABLE `subscription_plans_features`
  ADD CONSTRAINT `subscription_plans_features_subscription_plan_id_foreign` FOREIGN KEY (`subscription_plan_id`) REFERENCES `subscription_plans` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_schedule_event_id_foreign` FOREIGN KEY (`schedule_event_id`) REFERENCES `event_schedules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_personal_experience_id_foreign` FOREIGN KEY (`personal_experience_id`) REFERENCES `personal_experiences` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_google_event_schedules`
--
ALTER TABLE `user_google_event_schedules`
  ADD CONSTRAINT `user_google_event_schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_schedules`
--
ALTER TABLE `user_schedules`
  ADD CONSTRAINT `user_schedules_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_schedules_schedule_id_foreign` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_schedules_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD CONSTRAINT `user_settings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_transactions`
--
ALTER TABLE `user_transactions`
  ADD CONSTRAINT `user_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
