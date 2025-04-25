<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>YSEレジシステム</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
  <div class="bg-white p-6 rounded-2xl shadow-xl w-full max-w-md">
    <h1 class="text-2xl font-bold mb-4 text-center">YSEレジシステム</h1>

    <!-- 金額表示欄 -->
    <div class="mb-4">
      <input type="text" id="display" class="w-full p-3 text-right border rounded-lg text-xl" readonly value="0" />
    </div>

    <!-- ボタンエリア -->
    <div class="grid grid-cols-4 gap-2">
      <!-- 数字ボタン 3x3 -->
      <div class="grid grid-cols-3 gap-2 col-span-4">
        <button class="bg-gray-200 hover:bg-gray-300 p-3 rounded-lg text-xl" onclick="appendNumber('1')">1</button>
        <button class="bg-gray-200 hover:bg-gray-300 p-3 rounded-lg text-xl" onclick="appendNumber('2')">2</button>
        <button class="bg-gray-200 hover:bg-gray-300 p-3 rounded-lg text-xl" onclick="appendNumber('3')">3</button>
        <button class="bg-gray-200 hover:bg-gray-300 p-3 rounded-lg text-xl" onclick="appendNumber('4')">4</button>
        <button class="bg-gray-200 hover:bg-gray-300 p-3 rounded-lg text-xl" onclick="appendNumber('5')">5</button>
        <button class="bg-gray-200 hover:bg-gray-300 p-3 rounded-lg text-xl" onclick="appendNumber('6')">6</button>
        <button class="bg-gray-200 hover:bg-gray-300 p-3 rounded-lg text-xl" onclick="appendNumber('7')">7</button>
        <button class="bg-gray-200 hover:bg-gray-300 p-3 rounded-lg text-xl" onclick="appendNumber('8')">8</button>
        <button class="bg-gray-200 hover:bg-gray-300 p-3 rounded-lg text-xl" onclick="appendNumber('9')">9</button>
        <button class="bg-gray-200 hover:bg-gray-300 p-3 rounded-lg text-xl col-span-3" onclick="appendNumber('0')">0</button>
      </div>

      <!-- 操作ボタン -->
      <button class="bg-yellow-200 hover:bg-yellow-300 p-3 rounded-lg text-xl col-span-2" onclick="multiply()">× 個数</button>
      <button class="bg-green-200 hover:bg-green-300 p-3 rounded-lg text-xl" onclick="add()">＋</button>
      <button class="bg-blue-200 hover:bg-blue-300 p-3 rounded-lg text-xl" onclick="calculate()">＝</button>
      <button class="bg-purple-200 hover:bg-purple-300 p-3 rounded-lg text-xl" onclick="addTax()">税込み</button>
      <button class="bg-red-200 hover:bg-red-300 p-3 rounded-lg text-xl" onclick="clearDisplay()">AC</button>
      <button class="bg-indigo-200 hover:bg-indigo-300 p-3 rounded-lg text-xl col-span-2" onclick="saveSales()">計上</button>
      <button class="bg-pink-200 hover:bg-pink-300 p-3 rounded-lg text-xl col-span-2" onclick="showSales()">売上履歴</button>
      <button class="bg-pink-200 hover:bg-pink-300 p-3 rounded-lg text-xl col-span-2" onclick="CardSales()">カード読み取り</button>
    </div>
  </div>

  <script>
    let currentInput = '';
    let total = 0;
    let quantityMode = false;
    let lastNumber = 0;

    function updateDisplay(value) {
      document.getElementById('display').value = value;
    }

function appendNumber(num) {
  if (quantityMode) {
    // 数量入力中なら掛け算する
    const quantity = parseInt(num);
    const result = lastNumber * quantity;
    updateDisplay(result);
    currentInput = result.toString();
    quantityMode = false;
  } else {
    currentInput += num;
    updateDisplay(currentInput);
  }
}
    function multiply() {
      if (currentInput === '') return;
      lastNumber = parseFloat(currentInput);
      quantityMode = true;
      currentInput = '';
      updateDisplay('数量入力');
    }

    function add() {
      total += parseFloat(currentInput || '0');
      currentInput = '';
      updateDisplay(total);
    }

    function calculate() {
      total += parseFloat(currentInput || '0');
      updateDisplay(total);
      currentInput = '';
    }

    function addTax() {
      let value = parseFloat(currentInput || total || '0');
      let taxed = value * 1.1;
      updateDisplay(taxed.toFixed(0));
      currentInput = taxed.toFixed(0);
    }

    function clearDisplay() {
      currentInput = '';
      total = 0;
      quantityMode = false;
      lastNumber = 0;
      updateDisplay(0);
    }

    function saveSales() {
        window.location.href = 'update.php';
    }

    function showSales() {
        window.location.href = 'sales.php';
    }

    function CardSales(){
        window.location.href = 'card.php';

    }
    document.addEventListener('click', (e) => {
      if (e.target.tagName === 'BUTTON' && quantityMode && !isNaN(e.target.textContent)) {
        currentInput += e.target.textContent;
        if (currentInput !== '') {
          const quantity = parseInt(currentInput);
          const result = lastNumber * quantity;
          updateDisplay(result);
          currentInput = result.toString();
          quantityMode = false;
        }
      }
    });
  </script>
</body>

</html>