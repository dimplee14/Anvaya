-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2025 at 06:47 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anvaya`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_requests`
--

CREATE TABLE `contact_requests` (
  `request_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date_submitted` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','read') DEFAULT 'pending',
  `action_taken` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `designers`
--

CREATE TABLE `designers` (
  `designer_id` int(11) NOT NULL,
  `designer_name` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designers`
--

INSERT INTO `designers` (`designer_id`, `designer_name`, `username`, `password_hash`, `phone`, `email`, `created_at`) VALUES
(1, 'manish malhotra', 'manish.creater', '$2y$10$.ruDhXcUcXtFEpV37OnEpueKW95Y08wp1hg0TJ2s.3OW2ra8Y1lxm', '9845466525', 'manish@gmail.com', '2025-10-01 05:07:10'),
(2, 'yesha tarapara', 'yesha.designer', '$2y$10$lAM5BVUw45Q97IUjvVNdCu7tAGitW73H/Uq5HO9X1e1MEXtpx5VKO', '7895326154', 'yesha@gmail.come', '2025-10-01 06:07:02'),
(3, 'Sabyasachi Mukherjee', 'Sabyasachi_Designer', '$2y$10$s59behu7zk1iD7HpgUqswu89.Q9efzugdf4VSTheLYS0Bkq8YX0mi', '7895641230', 'sabyasachi@gmail.com', '2025-10-02 03:29:21'),
(4, 'Tarun Tahiliani', 'Tarun.FashionArt', '$2y$10$w/Ywh391EPRxe95/IVDY0u86om1dA35KYO66/QnoBAyvaPqoV638m', '2109872365', 'tarun@gmail.com', '2025-10-02 03:30:38'),
(5, 'Anita Dongre', 'Anita.StyleCraft', '$2y$10$xou/5FqBxw0X1B45bykqjevMf/C0hX0DsNkxmv3TYQsKGtKtckF8q', '6789563412', 'anita@gmail.com', '2025-10-02 03:31:51'),
(6, 'Ritu Kumar', 'Ritu.Elegance', '$2y$10$Z9bUwEuWRT3x0FOGRAJvf.pW8e0eaG0oA4DamtafqWVxfvONP0xh2', '7845213026', 'ritu@gmail.com', '2025-10-02 03:32:38'),
(7, 'Falguni Shane Peacock', 'FSP_Couture', '$2y$10$vPW9cWI7OmYesxobBUe.9.m3uwvwcxyhAla2k2ko9VkMxHHQuzI9W', '7898564521', 'falguni@gmail.com', '2025-10-02 03:33:55'),
(8, 'Masaba Gupta', 'Masaba.CreativeEdge', '$2y$10$qRnSB.EOT/94UUR5KZ/bp.IGLx4dXSP4PR/xZxDhadl6icqrTjetC', '9820311634', 'masaba@gmail.com', '2025-10-02 03:34:44'),
(9, 'Rahul Mishra', 'RahulM.SustainableLux', '$2y$10$IV4n.8umuaoAL/ieR8QHBeHOeu/jwmQP7SFiJcxk4.AuCT46T7Ytm', '7845211012', 'rahul@gmail.com', '2025-10-02 03:35:33'),
(10, 'Anamika Khanna', 'Anamika.FusionWear', '$2y$10$umIGFNIfF/P7qVCBQ9IGs.WpdKK.J972l/5BC0393E/cs/J51DQn.', '9021234697', 'anamika@gmail.com', '2025-10-02 03:36:24');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `preference_id` int(11) DEFAULT NULL,
  `designer_id` int(11) DEFAULT NULL,
  `delivery_address` text DEFAULT NULL,
  `status` enum('order_received','order_confirm','in_process','out_for_delivery','delivered','approve','reject') DEFAULT 'order_received',
  `final_style_desc` text DEFAULT NULL,
  `measurement` text DEFAULT NULL,
  `final_price` decimal(10,2) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `preference_id`, `designer_id`, `delivery_address`, `status`, `final_style_desc`, `measurement`, `final_price`, `delivery_date`, `created_at`) VALUES
(1, 1, 1, 1, 'sector 2/A, new Delhi', 'delivered', 'Elegant, form-fitted evening gown made with high-quality satin fabric. Features a deep V-neckline, structured bodice with boning, and a floor-length A-line skirt with a side slit. Embellished with hand-stitched beadwork and lace applique on the sleeves and hem.', 'Bust: 34 in, Waist: 26 in, Hips: 36 in, Length: 60 in, Sleeve: 22 in', 35000.00, '2025-10-16', '2025-10-01 05:04:48'),
(2, 2, 2, 10, 'sector 24/D , Chandigarh', 'delivered', 'Elegant designer gown with a fitted bodice and flared georgette skirt, featuring hand-embroidered sequin detailing, a deep back cut, and soft net drape. Perfect for upscale party events.', 'Bust: 34 in, Waist: 28 in, Hips: 36 in, Length: 58 in, Sleeve: Sleeveless', 48500.00, '2025-10-09', '2025-10-02 05:42:21'),
(3, 2, 3, 9, 'sector 24/D , Chandigarh', 'delivered', 'Classic Indo-western designer suit with a structured Nehru jacket in velvet, paired with a silk kurta and slim-fit trousers. Detailed with metallic buttons and subtle embroidery, ideal for evening parties.', 'Chest: 40 in, Waist: 34 in, Shoulder: 18 in, Sleeve: 25 in, Length: 42 in', 48900.00, '2025-10-09', '2025-10-02 05:42:21'),
(4, 2, 4, 3, NULL, 'approve', 'Signature Sabyasachi bridal lehenga in deep maroon velvet, adorned with intricate hand embroidery using zardozi, sequins, and antique gold threadwork. Comes with a structured blouse and dual dupattas – one sheer with a scalloped border, and one heavy veil-style for the wedding ceremony.', 'Bust: 36 in, Waist: 30 in, Hips: 38 in, Blouse Length: 14.5 in, Lehenga Length: 44 in, Dupatta: 2.5 m', 120000.00, '2025-11-28', '2025-10-02 08:26:24'),
(5, 3, 5, 8, 'East Mumbai', 'out_for_delivery', 'Trendy pastel lehenga by Masaba Gupta featuring bold prints and mirror embroidery, paired with a modern cropped blouse and lightweight dupatta — perfect for a chic engagement look.', 'Bust: 34 in, Waist: 28 in, Lehenga Length: 42 in, Dupatta: 2.25 m', 32000.00, '2025-10-27', '2025-10-03 03:48:07'),
(6, 4, 6, 9, 'Chittorgarh Rajasthan', 'out_for_delivery', 'Comfort-fit ethnic co-ord set in natural beige cotton-linen blend, featuring subtle thread embroidery on the kurta and relaxed straight pants. Perfect for festive day events or casual celebrations with an elegant, earthy vibe.', 'Bust: 40 in, Waist: 34 in, Hip: 42 in, Kurta Length: 42 in, Sleeve: 22 in, Pant Length: 38 in', 45000.00, '2025-11-04', '2025-10-03 03:56:04'),
(7, 5, 7, 4, 'Patna Bihar', 'in_process', 'Classic Jodhpuri kurta in deep navy-blue suiting fabric, featuring a structured bandhgala collar, concealed placket, and metallic buttons. Tailored for a regal silhouette, perfect for formal occasions and traditional gatherings.', 'Chest: 42 in  Waist: 38 in  Shoulder: 18 in  Sleeve Length: 25 in  Kurta Length: 42 in  Neck: 16 in', 48500.00, '2025-10-21', '2025-10-03 04:04:37'),
(8, 6, 8, 7, 'Ahmedabad Gujrat', 'in_process', 'Floor-length designer gown in flowing georgette fabric, featuring a fitted bodice with sequin embroidery, sweetheart neckline, and flared pleated skirt. Designed for elegance and comfort at receptions, cocktail parties, or formal evenings.', 'Bust: 38 in  Waist: 32 in  Hip: Free/Flared  Gown Length: 60 in  Shoulder: 14.5 in  Sleeve Length: Sleeveless / 5–6 in (if with cap sleeve)', 44000.00, '2025-10-07', '2025-10-03 04:23:17'),
(9, 7, 9, 5, 'Sector 2/C , Jammu & Kashmir', 'order_confirm', 'Smart-fit casual shirt crafted from premium cotton fabric in a natural tone. Features a mandarin collar, contrast buttons, and rolled-up sleeves with tab detailing. Perfect for everyday wear or casual social gatherings.', 'Chest: 42 in  Waist: 40 in  Shoulder: 18 in  Sleeve Length: 25 in (full)  Shirt Length: 29 in  Neck: 16 in', 48000.00, '2025-10-19', '2025-10-03 04:32:25'),
(10, 8, 10, 6, 'Thiruvananthapuram Kerala', 'order_confirm', 'Custom-designed Bandhgala jacket in a rich textured fabric with minimal embroidery accents on the collar and cuffs. Features a tailored fit, concealed buttons, and a soft inner lining — perfect for elegant party wear with a youthful twist.', 'Chest: 40 in  Waist: 36 in  Shoulder: 17.5 in  Sleeve Length: 25 in  Jacket Length: 29 in  Neck: 15.5 in  Height Range: 181–190 cm (adjusted for tall fit)', 49500.00, '2025-10-21', '2025-10-03 04:41:10');

-- --------------------------------------------------------

--
-- Table structure for table `order_status_history`
--

CREATE TABLE `order_status_history` (
  `status_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `status` enum('order_received','order_confirm','in_process','out_for_delivery','delivered','approve','reject') DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_text` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `order_id`, `user_id`, `rating`, `review_text`, `photo`, `created_at`) VALUES
(1, 1, 1, 5, '\\\"Absolutely stunning piece! The craftsmanship, fit, and fabric quality are exceptional. It feels luxurious and looks even better in person.\\\"', 'uploads/review_photos/review_1_1_1759298514.jpg', '2025-10-01 11:31:54'),
(2, 3, 2, 4, 'Impeccable tailoring and rich fabric made the outfit stand out. Got endless compliments at the party !!!', 'uploads/review_photos/review_2_3_1759393438.jpg', '2025-10-02 13:53:58'),
(3, 2, 2, 5, 'The gown was absolutely stunning — the fit, fabric, and detailing were flawless. I felt elegant and confident throughout the evening.', 'uploads/review_photos/review_2_2_1759393453.jpg', '2025-10-02 13:54:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `phone`, `password_hash`, `created_at`) VALUES
(1, 'amit', 'shah', 'amit@gmail.com', '7484445695', '$2y$10$AAbB4CT6NUmpDLauAfMUieUP8p9HOLEAQYuEgcBIi0djSvaIeTcCi', '2025-10-01 04:42:39'),
(2, 'Mehra', 'Aanya', 'Aanya@gmail.com', '8160635335', '$2y$10$oNF.HnZLI6pFjiEe5RWGEeaynK3bo2XmJhsc/VH2I1VkvLOC3tn0K', '2025-10-02 05:39:26'),
(3, 'Sneha', 'Reddy', 'sneha@gmail.com', '9012872465', '$2y$10$6RDTzC..nghsA04.StH1Y.rAsDC/z9rHKSJQjk.cb6LzCXT1RWm.W', '2025-10-03 03:46:57'),
(4, 'Arjun', 'Deshmukh', 'arjun@gmail.com', '7895632465', '$2y$10$g6OINDPXGl1q3HZtg75o/ezaFBSh9NFiLH.XJR49ChpZt7O.Nu6dW', '2025-10-03 03:54:54'),
(5, 'Aditya', 'Verma', 'aditya@gmail.com', '8956231245', '$2y$10$xKteU80Ct6F6YzVEZTcoxOlVsZ3JM7TQZgrQGMCmhXxJqhoOkrKDu', '2025-10-03 04:03:21'),
(6, 'Tanvi', 'Iyer', 'tanvi@gmail.com', '8523154697', '$2y$10$204umPRJmMjG8gNwCW52UuWUR5Rr4kqXDBUpPPwpQ2x3PReeHoUi.', '2025-10-03 04:18:30'),
(7, 'Devansh', 'Joshi', 'devansh@gmail.com', '9231644895', '$2y$10$kVohFSR7GY.6.QHsn6Y64ebbsJOg6V7lxG83Z8.TqlV9C4EmqIhFG', '2025-10-03 04:31:37'),
(8, 'Rohit', 'Bansal', 'rohit@gmail.com', '586497236', '$2y$10$lX9lUe8OWbKX/9cnSK2tdOLBaxBPVX9bDx5uXoIGbDW/B9xYZbrVS', '2025-10-03 04:40:13');

-- --------------------------------------------------------

--
-- Table structure for table `user_design_preferences`
--

CREATE TABLE `user_design_preferences` (
  `preference_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `occasion` varchar(50) DEFAULT NULL,
  `style` varchar(100) DEFAULT NULL,
  `budget` decimal(10,2) DEFAULT NULL,
  `liked_items` text DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `height` varchar(20) DEFAULT NULL,
  `approx_size` varchar(20) DEFAULT NULL,
  `colour` varchar(50) DEFAULT NULL,
  `uploaded_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_design_preferences`
--

INSERT INTO `user_design_preferences` (`preference_id`, `user_id`, `occasion`, `style`, `budget`, `liked_items`, `age`, `height`, `approx_size`, `colour`, `uploaded_photo`, `created_at`) VALUES
(1, 1, 'Festival or Small Event', 'Designer Suits', 30000.00, 'Pink Grace Designer Suit', 18, '161-170', 's', 'Pastel colors', '68dcb3ed02edc_1.1.jpg,68dcb3ed0370d_1.1.png,68dcb3ed0389b_1.2.jpg,68dcb3ed03a22_1.3.jpg,68dcb3ed03b9a_1.jpg', '2025-10-01 01:24:05'),
(2, 2, 'Birthday or Parties', 'Evening Gown / Party Gown', 50000.00, 'Blue Flow Gown', 0, '171-180', 'l', 'Neutral tones (beige, white, gray)', NULL, '2025-10-02 02:10:33'),
(3, 2, 'Birthday or Parties', 'Designer Suits', 50000.00, 'Beige Royal Designer Suit', 18, '181-190', 'l', 'Neutral tones (beige, white, gray)', NULL, '2025-10-02 02:11:24'),
(4, 2, 'Wedding', 'Lehenga', 100000.00, 'Ivory Mirror Lehenga', 26, '161-170', 'l', 'custom', NULL, '2025-10-02 04:55:58'),
(5, 3, 'Engagement or Reception', 'Custom / Other', 30000.00, 'Rose Glow Designer Suit', 26, '161-170', 'l', 'custom', NULL, '2025-10-03 00:17:58'),
(6, 4, 'Festival or Small Event', 'Casual Shirt', 50000.00, 'White Classic Sherwani', 18, '181-190', 'l', 'Neutral tones (beige, white, gray)', NULL, '2025-10-03 00:25:41'),
(7, 5, 'Family Function / Traditional Ceremony', 'jodhpuri', 50000.00, 'Maroon Royal Jodhpuri', 18, '181-190', 'l', 'custom', '68df4b50c10e4_jodhpuri1.jpg', '2025-10-03 00:34:32'),
(8, 6, 'Birthday or Parties', 'Evening Gown / Party Gown', 100000.00, '', 18, '161-170', 'l', 'custom', '68df4f943e8e2_Gown2.jpg,68df4f943ed54_Gown3.jpg,68df4f943f158_Gown4.jpg,68df4f943f519_Gown5.jpg', '2025-10-03 00:52:44'),
(9, 7, 'Other', 'Custom / Other', 50000.00, 'White Classic Casual Shirt', 18, '181-190', 'l', 'custom', NULL, '2025-10-03 01:02:18'),
(10, 8, 'Birthday or Parties', 'Bandhgala', 30000.00, '', 18, '181-190', 'm', 'custom', NULL, '2025-10-03 01:11:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `contact_requests`
--
ALTER TABLE `contact_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `designers`
--
ALTER TABLE `designers`
  ADD PRIMARY KEY (`designer_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `preference_id` (`preference_id`),
  ADD KEY `designer_id` (`designer_id`);

--
-- Indexes for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD PRIMARY KEY (`status_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `user_design_preferences`
--
ALTER TABLE `user_design_preferences`
  ADD PRIMARY KEY (`preference_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_requests`
--
ALTER TABLE `contact_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designers`
--
ALTER TABLE `designers`
  MODIFY `designer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_design_preferences`
--
ALTER TABLE `user_design_preferences`
  MODIFY `preference_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`preference_id`) REFERENCES `user_design_preferences` (`preference_id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`designer_id`) REFERENCES `designers` (`designer_id`);

--
-- Constraints for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD CONSTRAINT `order_status_history_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_design_preferences`
--
ALTER TABLE `user_design_preferences`
  ADD CONSTRAINT `user_design_preferences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
