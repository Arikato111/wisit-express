## WISIT-EXPRESS ( API )
### นี่คือ module ที่จะมาช่วยในการเขียน API
### 1.0 ( Type ) version
---
### About
#### เป็น Type เวอร์ชั่นที่จะปรับให้เป็นการเขียนแบบธรรมดาเพื่อรองรับ Tools ต่างๆ 

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
- **นี่คือ** `module` เสริมที่จะมาช่วยในเรื่องของการเขียน api ให้เขียนได้สะดวกยิ่งขึ้น ซึ่งจะทำงานบนหน้า index.php เท่านั้น คล้ายกับการเขียนบน JavaScript 

- **ซึ่งในขณะนี้ยังรองรับอยู่ 4 method คือ**
	- GET
	- POST
	- PUT
	- DELETE

---
### การ require เข้ามาใช้งาน
- ในเวอร์ชั่นนี้จะใช้การ `require` แบบธรรมดาๆ
	```php
	require('modules/wisit-express/main.m.php');
	```
- หากใช้ `use-import` library
	```php
	import('wisit-express');
	```
---
### ตั้งค่าแสดงข้อผิดพลาด
- ด้วยที่เป็น API อาจจะมีการโชว์ ERROR ออกไปโดยไม่จำเป็น จึงได้มีการทำให้สามารถปิดการแสดง ERROR ได้ โดยใช้ 
	```php
	Wexpress::showError(false);
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

- ในการเรียกใช้ตัวรับ `method` นั้นหลังจากการ `require` module แล้ว จะสามารถใช้ `Wexpress` เพื่อรับ method ต่างๆ ได้

  
- การเขียนจริงๆ จะเป็นตามโค้ดด้านล่าง
```php
Wexpress::get('/', function() {
    $about  = [
		'name'=>'Nawasan',
		'age'=>20
	];
    Res::json($about);
});
```

- ตามตัวอย่างด้านบนคือการเขียนรับ `request` ประเภท get และ `response` เป็น json
- ตัว `Wexpress::get()` จะรับค่า path และ Callback function ซึ่งตัว callback function จะใช้ `Req` และ `Res` เพื่อใช้ในการรับส่งข้อมูล
- อย่างในโค้ดด้านบนนั้นเป็นการส่งค่า json ออกไป 

- ตัว path นั้นสามารถกำหนดให้เป็นแบบ dynamic ได้โดยใช้ `:` เช่น `/:` หรือ `/value/:`

- และใน method ประเภทอื่นๆ ก็จะเขียนแบบเดียวกัน

- หากต้องการ **custom** method สามารถใช้ `Route` ได้
```php
Wexpress::Route('POST', '/', function() {
    $about  = [
		'name'=>'Nawasan',
		'age'=>20
	];
    Res::json($about);
});
```


---

### Request
- สำหรับตัว `Req` ที่ใช้ใน Callback function นั้น ตัว `Req` จะมี type เป็น class ที่มี function ด้านใน 4 function คือ

	- `Res::header()` จะเป็นตัวรับค่า headers ที่ส่งมา

	- `Req::body()` จะเป็นตัวรับค่า value ที่ส่งมาผ่าน body ซึ่งจะ return เป็นข้อมูลที่ส่งมา
	
	- `Req::query()` จะเป็นตัวดึงค่า url parameter และ return เป็น array ซึ่งสามารถสร้างตัวแปรปกติมารับค่าได้ แต่หากต้องการรับค่าแค่บางค่าเท่านั้น ก็สามารถเขียนแบบนี้ได้ 
    	- `['name' => $name] =  Req::query();`
	 ตัว `name` คือชื่อตัวแปรที่ต้องการรับ และ `$name` คือตัวแปรที่มารับค่า
	- `Req::params()` คือการดึงค่า path ตำแหน่งสุดท้าย เช่น `/about/name` ตำแหน่งสุดท้ายก็คือ name ก็จะได้ name มา
	หรือหากต้องการระบุตำแหน่งก็สามารถใส่ตำแหน่งลงไปได้ โดยเริ่มนับตำแหน่งแรกเป็นตำแหน่งที่ 0
	---

### Response
- สำหรับตัว `Res` ที่ใช้ใน Callback function นั้น ตัว `Res` จะมี type เป็น Class ที่มี function ด้านใน 4 function คือ

	- `Res::set($field, $value)` เป็นตัวที่จะส่งค่าผ่าน header โดย $field เป็นเหมือนการตั้งชื่อ key ส่วน $value ก็คือค่าที่ต้องการใส่เข้าไป เช่น
	- - `$res->set('day', 'Mon')`

	- `Res::send()` คือการส่ง response ออกไปในรูปแบบ string โดยใส่ string ธรรมดาลงไปใน function
	
	- `Res::status()` คือการส่งรหัสสถานะต่างๆ เช่น 404 , 200 ซึ่งจะใส่ตัวเลขรหัดลงใน function
	- `Res::json()` คือการส่ง response ออกไปในรูปแบบ json โดยใส่ PHP Array หรือ PHP Associative Arrays ลงใน function
---
### Origin
- หากมีปัญหาเกี่ยวกับ cors สามารถใช้ `Wexpress::origin()` เพื่ออนุญาต origin ในการเรียกใช้ api ได้ หรือหากต้องการระบุ origin เฉพาะก็สามารถทำได้โดยการใส่ origin ในรูปแบบ array เช่น 
```php
$express->origin([
	'http://yourdomain',
]);
```
- แน่นอนว่าสามารถใส่ได้มากกว่าหนึ่ง
---

### ติดตั้ง

- วิธีที่ 0 ใช้ control ในการติดตั้ง โดยหลังจากทำการลง [control](https://github.com/Arikato111/control) เรียบร้อยให้ใช้คำสั่งด้านล่าง

```
php control install wisit-express@type
```

-   วิธีที่ 1  **ติดตั้งผ่านคำสั่ง php**  , โดยคัดลอกโค้ดด้านล่างไปวางไว้ที่ installer.php แล้วเข้าหน้า installer.php ผ่านเบราว์เซอร์ รอสักครู่ เป็นอันเสร็จสิ้น
```php
<?php
eval(file_get_contents('https://raw.githubusercontent.com/Arikato111/wisit-express/installer/type.txt'));
```

- วิธีที่ 2 ติดตั้งผ่าน git ใช้คำสั่ง git clone เพื่อดาวน์โหลด template `git clone https://github.com/Arikato111/wisit-express.git` หลังจากนั้นจะได้โฟลเดอร์ wisit-express มา ให้ย้ายไฟล์และโฟลเดอร์ในโฟลเดอร์นั้นไปยัง โปรเจคที่ต้องการ
