1.html->js->php->database

DataBase:

users:
user_name //使用者名稱
user_id //使用者id (PK)
user_password //使用者密碼
state_number //使用者狀態 1在線 0離線

dialogue:
user_id //使用者id (外來鍵)
message //訊息內容
time //傳送時間紀錄


檔案用途:

login.php //登錄介面(要改成index.php)
chat.php //對話介面
DB_connect.php //資料庫連線
GetOnlineCount.php //在線人數計算
save_message.php //對話內容送入DB & 回傳到前端
Show_username.php //顯示在線用戶
Store_username.php //新舊用戶確認
update_status.php //用戶狀態更新


已完成:
//建立user+dialogue資料庫
//登錄介面html
//聊天介面html
//登錄介面跳轉聊天介面
//登錄介面輸入用戶名稱+密碼才可登錄
//用戶名稱顯示在對話氣泡框上
//用戶名稱隨著登錄人員不同顯示不同
//按下登出button跳轉回登錄介面
//增加輸入密碼 密碼+用戶名一致不產生新的uid 繼續使用舊的uid
//要匹配使用者和密碼一致才進入
//登錄和新建立狀態都=1(state_number)
//按下登出狀態=0
//當前此帳號登錄者名稱顯示在在線列表 按下登錄就顯示使用者名稱
//按下登出同時會從在線列表消失
//在線人數計數
//bug 按下登綠一次會新增2筆資料(找到哪裡新增2筆)
//每個登錄者名稱不重疊
//登錄者同時可以發言 不被取代掉(user_id不一致的時候不取代)
//多人不同地登錄對話ex:不同分頁不同人登錄
//對話框每1秒刷新一次
//資料庫紀錄時間
//對話依照時間排序上到下
//顯示使用者名稱在對話框正上方
//如果有新的使用者登陸要自動刷新在線列表(在線列表100ms刷新一次)
//自己端發出顯示在sent 他人發出顯示在received(左右排版)
//如果有紀錄session就直接進入chat.php 否則導到index.html
//登出清除session
//滾輪可以上滾查看舊的對話
//新增一鍵到底button(開始查看舊紀錄才顯示)
//在線列表到達一定上限要上捲(在線人數顯示上限為100)
//新增首頁要有兩個button(登陸&註冊)
//新增註冊介面
//新增註冊介面(store_user.php的else部分再拆一個php，註冊要doublecheck密碼)
//新增首頁 選擇註冊or登錄(如果在登錄沒有用戶名要跳出提醒轉到註冊介面)
//註冊介面輸入密碼不相同顯示警告框，回到註冊頁面（用戶名依然存在）
//註冊＆登入界面加入 返回鍵（返回首頁）
//紀錄IP
//對話顯示傳送消息的時間
//登出後轉到login.php
//index.html button動畫調整


//註冊用戶名不能和資料庫一樣

前:


完成註冊應該跳出完成註冊的顯示框，按下確認再返回登陸介面
debug 對話框一鍵到底button如果螢幕長度太長會自己先顯示 不合理
debug 註冊&登錄的back登錄的back button位置要固定好 不然可能會亂跑
登陸輸錯密碼 應該保留用戶名 跳出錯誤警告框但不跳轉介面


未完成(如果太閒的話):

刷新時滾輪可以上滾
對話發送時間(資料庫新增time)
超過5分鐘沒說話 在線列表顯示"暫離"
加入HTTP狀態碼
加HTTP
個人中心 顯示用戶名和UID(這可以區別同名不同人)
響應式介面
搜尋對話功能(依關鍵字)
搜尋對話(依日期 有個日曆表可點 當天有消息日曆表才亮 否則日曆表呈灰色)
聊天框顯示哪段到哪段是什麼時候的對話(ex:Today Yesterday Tue,11/16(星期,日期)) (對話要新增日期資料庫 要抓取當日日期)
user_id歸0
掛機30分鐘自動登出 or 進入休眠介面
關閉介面state_number=0
哪段到哪段是什麼時候的對話(ex:Today Yesterday Tue,11/16(星期,日期)) (對話要新增日期資料庫 要抓取當日日期)


魔王(我嫌麻煩):
如果在另外一個介面登錄 原先登錄的使用者就自動登出回到login.php介面
使用mail當user_id登錄 如果mail註冊過不可再註冊
新增註冊介面 拿掉自動給uid功能 mail直接=user_id



在線狀態->如果按下登出->狀態變成0(登出)->從列表消失
在線狀態->超過5分鐘沒說話->狀態2 (暫離)
狀態0 登出
狀態1 上線中
狀態2 暫離



發出對話 使用AJAX 將對話內容存入資料庫 並將對話和用戶名顯示到前端

1.先發出一個ajax到後端取得user_id和user_name
2.寫一個搜尋user_id和user_name的search.php使用.json返回到前端給ajax
3.回到前端後將user_id和message打包丟回後端給存入dialogue資料庫的saveMessage.php
4.最後將user_name和message顯示在前端
5.然後要向ajax发出请求来检查是否有新消息。这种方式会在一定时间间隔内不断请求服务器，以获取新消息


多人對話完成步驟:
.js 按下button取得message
message連同當前時間和user_id送入save_message.php(.json)
 
save_message.php
1.把message存入資料庫
2.搜尋所有資料庫的data(一秒搜尋一次or無窮迴圈 不斷搜尋)
3.回傳data(包含 user_name,user_id,message)
4.js將收到的data輸出到介面上




刪除資料庫語法
DELETE FROM `自己填` 




