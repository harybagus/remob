-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2023 at 03:14 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `remob`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `image`, `password`) VALUES
(1, 'Admin Satu', 'adminsatu@remob.co.id', 'default.jpg', '$2y$10$IE2YVThAQO7g9a4lFi95Wek2Bv0aDYAWrKtYg2lhxXKs/fHTXNYbW'),
(2, 'Admin Dua', 'admindua@remob.co.id', 'default.jpg', '$2y$10$8sxU6LuyBCYVq2Arnd/Qde38LHxxmdxctBQ1uKQfP0gXKt.fntYKS');

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `merk` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `transmission` varchar(128) NOT NULL,
  `seat` int(1) NOT NULL,
  `number_of_cars` int(11) NOT NULL,
  `rental_price_per_day` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`id`, `name`, `merk`, `image`, `transmission`, `seat`, `number_of_cars`, `rental_price_per_day`) VALUES
(1, 'Brio Satya', 'Honda', '1701095509_5ed292b46ee9a9dbadd9.png', 'Manual', 5, 3, 100000),
(2, 'Avanza', 'Toyota', '1701095604_00e599c5bf516bcde203.png', 'Matik', 7, 5, 150000),
(3, 'Agya', 'Toyota', '1701091020_6c519c7a52f4cbec2530.png', 'Manual', 5, 0, 100000),
(4, 'WR-V', 'Honda', '1701095618_8e1caa4c2d9dc7455274.png', 'Matik', 5, 4, 125000),
(5, 'Calya', 'Toyota', '1701092067_bbefe8c54b7404c9b9ff.png', 'Matik', 5, 2, 110000);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `menu`) VALUES
(1, 'Utama'),
(2, 'Mobil'),
(3, 'Penyewaan');

-- --------------------------------------------------------

--
-- Table structure for table `rental`
--

CREATE TABLE `rental` (
  `id` int(11) NOT NULL,
  `renter_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `rental_price_per_day` int(11) NOT NULL,
  `total_rental_price` int(11) NOT NULL,
  `rental_start` date NOT NULL,
  `rental_end` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rental`
--

INSERT INTO `rental` (`id`, `renter_id`, `car_id`, `rental_price_per_day`, `total_rental_price`, `rental_start`, `rental_end`, `status`) VALUES
(1, 1, 4, 125000, 250000, '2023-12-02', '2023-12-03', 2),
(2, 9, 1, 100000, 300000, '2023-12-02', '2023-12-04', 2),
(3, 7, 2, 150000, 150000, '2023-12-03', '2023-12-03', 2),
(4, 1, 5, 110000, 110000, '2023-12-04', '2023-12-04', 1),
(5, 7, 3, 100000, 0, '2023-12-04', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `renter`
--

CREATE TABLE `renter` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile_phone_number` char(13) NOT NULL,
  `ktp_image` varchar(128) NOT NULL,
  `sim_image` varchar(128) NOT NULL,
  `balance` int(11) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `renter`
--

INSERT INTO `renter` (`id`, `name`, `email`, `image`, `password`, `mobile_phone_number`, `ktp_image`, `sim_image`, `balance`, `date_created`) VALUES
(1, 'Thomas Febry Cahyono', 'mas@cahyono.my.id', 'default.jpg', '$2y$10$ccElyl0/cSIVArNQBbtQDeIB9h8Np7s8R2HhBupE628bj4MxDfvVq', '087889983443', '1701398993_fefdd62a5df54f3cd820.png', '1701398993_8d33733617dc8ce390df.jpg', 50000, 1701166754),
(4, 'Bagus Hary', 'bagus@banget.com', '1701185784_770bfc2cc0cdb9207be1.png', '$2y$10$gwXDSve0cm.wNWDtGBFlAOmFyn21xLQOGApLIGrsQ0FifDjEQQML6', '', '', '', 0, 1701265243),
(7, 'Muhammad Nias D.K.', 'niasaerox@gmail.com', 'default.jpg', '$2y$10$FppG03GcU4.z4SzHXwpbduUS9EfwPCmbxfNdwsrg.8GPQqlp1QLCi', '08994321864', '1701573035_3fecaee5daf92f5ef68d.png', '1701573035_c9dcae93a113c21074a8.jpg', 0, 1701496792),
(8, 'Alvian Nur Isra', 'iyan@alvian.xyz', 'default.jpg', '$2y$10$Smkd.el1Wi0Bgiu6qb4Q8.SekeJG6Llb0L7ctzPsalq6geBeNfBRm', '', '', '', 0, 1701496831),
(9, 'Buana Rizki N.H.', 'buana@ganteng.com', 'default.jpg', '$2y$10$rY8IZPu9oKvkOKbSBxCBfOE4fYsATR/.ZS/j8qha/APvhepcwHueO', '081283389229', '1701572462_00475e380eb94c7d4c22.png', '1701572462_50142ea0349b9ec14b23.jpg', 200000, 1701496916);

-- --------------------------------------------------------

--
-- Table structure for table `sub_menu`
--

CREATE TABLE `sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `role` varchar(6) NOT NULL,
  `title` varchar(128) NOT NULL,
  `url` varchar(128) NOT NULL,
  `icon` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_menu`
--

INSERT INTO `sub_menu` (`id`, `menu_id`, `role`, `title`, `url`, `icon`) VALUES
(1, 1, 'admin', 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt'),
(2, 2, 'admin', 'Data Mobil', 'admin/car', 'fas fa-fw fa-car'),
(3, 3, 'admin', 'Data Penyewa', 'admin/renter', 'fas fa-fw fa-user'),
(4, 3, 'admin', 'Data Penyewaan', 'admin/rental', 'fas fa-fw fa-receipt'),
(5, 1, 'renter', 'Profil Saya', 'renter', 'fas fa-fw fa-user'),
(6, 2, 'renter', 'Data Mobil', 'renter/car', 'fas fa-fw fa-car'),
(7, 3, 'renter', 'Data Penyewaan', 'renter/rental-data', 'fas fa-fw fa-receipt');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rental`
--
ALTER TABLE `rental`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `renter`
--
ALTER TABLE `renter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rental`
--
ALTER TABLE `rental`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `renter`
--
ALTER TABLE `renter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
