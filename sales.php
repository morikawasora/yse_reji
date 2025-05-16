<?php
// sales.php - データベースから売上一覧と合計を取得

$dsn = 'mysql:host=localhost;dbname=yse_register;charset=utf8';
$user = 'root'; // 環境に合わせて変更
$password = '';
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
  $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
  die('DB接続失敗: ' . $e->getMessage());
}

// パラメータ取得
$selectedYear = $_GET['year'] ?? date('Y');
$selectedMonth = $_GET['month'] ?? date('n');

// 売上取得
$stmt = $pdo->prepare("SELECT * FROM sales WHERE YEAR(created_at) = :year AND MONTH(created_at) = :month ORDER BY created_at DESC");
$stmt->execute([':year' => $selectedYear, ':month' => $selectedMonth]);
$sales = $stmt->fetchAll();
$total = array_sum(array_column($sales, 'amount'));

$years = range(date('Y'), 2023);
$months = range(1, 12);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YSEレジ 売上</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
  <main class="max-w-3xl mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold text-center mb-6">売上管理</h2>

    <!-- 検索フォーム -->
    <form method="get" class="bg-white p-6 rounded-lg shadow mb-6">
      <div class="flex flex-wrap items-center justify-center gap-4 mb-4">
        <div>
          <label class="block mb-1 font-semibold">年</label>
          <select name="year" class="border rounded px-3 py-2">
            <?php foreach ($years as $year) : ?>
              <option value="<?= $year ?>" <?= $year == $selectedYear ? 'selected' : '' ?>><?= $year ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <div>
          <label class="block mb-1 font-semibold">月</label>
          <select name="month" class="border rounded px-3 py-2">
            <?php foreach ($months as $month) : ?>
              <option value="<?= $month ?>" <?= $month == $selectedMonth ? 'selected' : '' ?>><?= $month ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>
      <div class="flex flex-col sm:flex-row justify-center gap-3">
        <button class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">検索</button>
        <a href="./sales.php" class="bg-gray-500 text-white px-5 py-2 rounded hover:bg-gray-600 text-center">クリア</a>
        <a href="index.php" class="bg-gray-200 text-blue-600 px-5 py-2 text-center">戻る</a>
      </div>
    </form>

    <!-- 総売上 -->
    <div class="bg-white p-4 rounded-lg shadow mb-6 text-center">
      <h3 class="text-xl font-semibold mb-2">総売上金額</h3>
      <p class="text-3xl font-bold text-green-600">&yen;<?= number_format($total) ?></p>
    </div>

    <!-- 売上一覧 -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
      <table class="min-w-full text-sm text-left">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-6 py-3 font-medium text-gray-700">ID</th>
            <th class="px-6 py-3 font-medium text-gray-700">売上日時</th>
            <th class="px-6 py-3 font-medium text-gray-700">売上高</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <?php foreach ($sales as $s): ?>
            <tr>
              <td class="px-6 py-4 font-mono"><?= htmlspecialchars($s['id']) ?></td>
              <td class="px-6 py-4"><?= htmlspecialchars($s['created_at']) ?></td>
              <td class="px-6 py-4">&yen;<?= number_format($s['amount']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
