## WISIT-EXPRESS ( API )

### นี่คือ module ที่จะมาช่วยในการเขียน API

### 1.0 version

---

### what news!

เพิ่ม origin ที่จะมาช่วยแก้ปัญหาการติด cors

---

#### Menu

[Get started](#get-started)

[ติดตั้ง](#ติดตั้ง)

  

[การ require เข้ามาใช้งาน](#การ-require-เข้ามาใช้งาน)

[ตั้งค่าแสดงข้อผิดพลาด](#ตั้งค่าแสดงข้อผิดพลาด)
  
[METHOD](#method)

[Request](#request)

[Response](#response)

[Origin](#origin)

---

### Get started

-  **นี่คือ**  `module` เสริมที่จะมาช่วยในเรื่องของการเขียน api ให้เขียนได้สะดวกยิ่งขึ้น ซึ่งจะทำงานบนหน้า index.php เท่านั้น คล้ายกับการเขียนบน JavaScript

-  **ซึ่งในขณะนี้ยังรองรับอยู่ 4 method คือ**

- GET

- POST

- PUT

- DELETE

---

### การ require เข้ามาใช้งาน

- สำหรับการ `require` นั้น จะใช้คำสั่ง `require` ตามปกติ เพียงแต่ว่าต้องมีการสร้างตัวแปรมารับค่า เช่นโค้ดด้านล่าง

```php
$express = require('modules/wisit-express/main.m.php');
```
- หากใช้ `use-import` library
```php
$express = import('wisit-express');
```

และตัวแปรนั้นก็จะมีค่าเป็น object ซึ่งสามารถเรียกใช้ method ต่างๆ ได้

  

---

### ตั้งค่าแสดงข้อผิดพลาด

- ด้วยที่เป็น API อาจจะมีการโชว์ ERROR ออกไปโดยไม่จำเป็น จึงได้มีการทำให้สามารถปิดการแสดง ERROR ได้ โดยใช้

```php
$express->showError(false);
```

ซึ่งกำหนดเป็น `false` คือ ไม่ให้โชว์ ERROR

---

### METHOD

- ตอนนี้ยังรองรับ `method` อยู่ 4 ประเภท คือ

- GET

- POST

- PUT

- DELETE

  

- การเขียนรับ `request` ตามประเภทของ method ต่างๆ

  

- ในการเรียกใช้ตัวรับ `method` นั้นจะต้องมีการ `require` module เข้ามาใช้งานก่อน โดยมีตัวแปรมารับค่า ทั้งนี้จะตั้งชื่อเป็นอะไรก็ได้ แต่จะแนะนำให้ตั้งเป็น `$express`

  

- จากนั้นตัวแปร `$express` จะมี `type` เป็น object ซึ่งสามารถเรียกใช้ method ต่างๆ โดยเขียนแบบนี้ `$express->get()` ซึ่ง get คือ method GET นั่นเอง ซึ่งหากต้องการเป็น method อื่นก็เขียนแบบเดียวกัน แต่เปลี่ยน get เป็น method นั้นๆ ตามต้องการ ซึ่งจะเขียนเป็นตัวเล็กทั้งหมด

- การเขียนจริงๆ จะเป็นตามโค้ดด้านล่าง

```php
$express->get('/', function ($req, $res) {
	$about = [
		'name'=>'Nawasan',
		'age'=>20
	];
	$res->json($about);
});

```

  

- ตามตัวอย่างด้านบนคือการเขียนรับ `request` ประเภท get และ `response` เป็น json

- ตัว `$express->get()` จะรับค่า path และ Callback function ซึ่งตัว callback function จะรับ `$req` และ `$res` เพื่อใช้ในการรับส่งข้อมูล

- อย่างในโค้ดด้านบนนั้นเป็นการส่งค่า json ออกไป

  

- ตัว path นั้นสามารถกำหนดให้เป็นแบบ dynamic ได้โดยใช้ `:` เช่น `/:` หรือ `/value/:`

  

- และใน method ประเภทอื่นๆ ก็จะเขียนแบบเดียวกัน

 - สามารถ  custom ตัว method ได้โดยการใช้ `Route` method 
 
```php
$express->Route('POST', '/', function ($req, $res) {
	$about = [
		'name'=>'Nawasan',
		'age'=>20
	];
	$res->json($about);
});
```

---

  

### Request

- สำหรับตัว `$req` ที่ใส่ลงใน Callback function นั้น ตัว `$req` จะมี type เป็น object ที่มี function ด้านใน 4 function คือ

- `$req->header()` จะเป็นตัวรับค่า headers ที่ส่งมา

-  `$req->body()` จะเป็นตัวรับค่า value ที่ส่งมาผ่าน body ซึ่งจะ return เป็นข้อมูลที่ส่งมา

-  `$req->query()` จะเป็นตัวดึงค่า url parameter และ return เป็น array ซึ่งสามารถสร้างตัวแปรปกติมารับค่าได้ แต่หากต้องการรับค่าแค่บางค่าเท่านั้น ก็สามารถเขียนแบบนี้ได้

- - `['name' => $name] = $req->query();`

ตัว `name` คือชื่อตัวแปรที่ต้องการรับ และ `$name` คือตัวแปรที่มารับค่า

-  `$req->params()` คือการดึงค่า path ตำแหน่งสุดท้าย เช่น `/about/name` ตำแหน่งสุดท้ายก็คือ name ก็จะได้ name มา

หรือหากต้องการระบุตำแหน่งก็สามารถใส่ตำแหน่งลงไปได้ โดยเริ่มนับตำแหน่งแรกเป็นตำแหน่งที่ 0

---

  

### Response

- สำหรับตัว `$res` ที่ใส่ลงใน Callback function นั้น ตัว `$res` จะมี type เป็น object ที่มี function ด้านใน 4 function คือ

- `$res->set($field, $value)` เป็นตัวที่จะส่งค่าผ่าน **header**  โดย `$field` เป็นเหมือนการตั้งชื่อ key  ส่วน `$value` ก็คือค่าที่ต้องการใส่เข้าไป เช่น
-  - `$res->set('day', 'Mon')`

-  `$res->send()` คือการส่ง response ออกไปในรูปแบบ string โดยใส่ string ธรรมดาลงไปใน function

-  `$res->status()` คือการส่งรหัสสถานะต่างๆ เช่น 404 , 200 ซึ่งจะใส่ตัวเลขรหัดลงใน function

-  `$res->json()` คือการส่ง response ออกไปในรูปแบบ json โดยใส่ PHP Array หรือ PHP Associative Arrays ลงใน function

---

### Origin

- หากมีปัญหาเกี่ยวกับ cors สามารถใช้ `$express->origin()` เพื่ออนุญาต origin ในการเรียกใช้ api ได้ หรือหากต้องการระบุ origin เฉพาะก็สามารถทำได้โดยการใส่ origin ในรูปแบบ array เช่น

```php
$express->origin([
	'http://yourorigin',
]);
```

- แน่นอนว่าสามารถใส่ได้มากกว่าหนึ่ง

---

  

### ติดตั้ง

- วิธีที่ 0 ใช้ [control](https://github.com/Arikato111/control) ในการติดตั้ง โดยหลังจากทำการลง control เรียบร้อยให้ใช้คำสั่งด้านล่าง

```
php control install wisit-express
```

- วิธีที่ 1 **ติดตั้งผ่านคำสั่ง php** , โดยคัดลอกโค้ดด้านล่างไปวางไว้ที่ installer.php แล้วเข้าหน้า installer.php ผ่านเบราว์เซอร์ รอสักครู่ เป็นอันเสร็จสิ้น

```php
<?php
eval(file_get_contents('https://raw.githubusercontent.com/Arikato111/wisit-express/installer/Release1-0.txt'));
```

- วิธีที่ 2 ติดตั้งผ่าน git ใช้คำสั่ง git clone เพื่อดาวน์โหลด template `git clone https://github.com/Arikato111/wisit-express.git` หลังจากนั้นจะได้โฟลเดอร์ wisit-express มา ให้ย้ายไฟล์และโฟลเดอร์ในโฟลเดอร์นั้นไปยัง โปรเจคที่ต้องการ