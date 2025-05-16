<?php

$dsn = 'mysql:host=localhost;dbname=yse_register;charset=utf8';
$user = 'root'; // 必要に応じて変更
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $amount = $_POST['amount'] ?? '';

  if (is_numeric($amount) && $amount > 0) {
    $stmt = $pdo->prepare("INSERT INTO sales (amount) VALUES (:amount)");
    $stmt->execute([':amount' => $amount]);
    $message = "計上が成功しました！";
  } else {
    $message = "有効な金額を入力してください";
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>計上処理</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
    <h1 class="text-2xl font-bold text-center mb-6">売上計上</h1>

    <?php if (!empty($message)) : ?>
      <div class="mb-4 text-center text-green-600 font-semibold">
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <form action="" method="post" class="space-y-4">
      <label class="block">
        <span class="block mb-1 font-medium">金額（円）</span>
        <input type="number" name="amount" class="w-full p-2 border rounded" placeholder="例：1000" required>
      </label>

      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        計上する
      </button>
    </form>

    <div class="mt-6 text-center">
      <a href="sales.php" class="text-blue-600 hover:underline">売上を見る</a>
      <span class="mx-2">|</span>
      <a href="index.php" class="text-blue-600 hover:underline">金額入力画面に戻る</a>
    </div>
  </div>
</body>
</html>
