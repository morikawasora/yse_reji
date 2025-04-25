SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `sales` (
  `id` bigint(20) NOT NULL,
  `datatime` timestamp NULL DEFAULT current_timestamp(),
  `amount` bigint(20) NOT NULL,
  `reciet_no` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `sales` (`id`, `datatime`, `amount`, `reciet_no`) VALUES
(1, '2025-04-25 05:08:05', 1000, '00000001'),
(2, '2025-04-25 05:09:34', 2000, '00000002'),
(3, '2025-04-25 05:10:19', 3000, '00000003');

ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `sales`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;