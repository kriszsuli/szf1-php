Készíts egy teljes funkcionalitású bejelentkezési rendszert, amely a következőket tartalmazza:

- Bejelentkezési űrlap (GET és POST metódusok kezelése).
- Felhasználói adatok validálása és szűrése.
- Szeánszkezelés és sütik használata a felhasználói élmény fokozása érdekében.
- Kilépés funkció, amely lezárja a szeánszot és törli a sütiket.

---

### **Feladatok Részletezése**

#### **1. Feladat: HTML űrlapok létrehozása GET és POST metódusokkal**

Készíts egy **`login.php`** oldalt, amely tartalmaz egy bejelentkezési űrlapot az alábbi mezőkkel:

1. **Felhasználónév** _(kötelező mező)_
   - Csak alfanumerikus karaktereket engedélyez.
   - Minimális hossz: 5 karakter.
2. **Jelszó** _(kötelező mező)_
   - Legyen legalább 8 karakter hosszú.
   - Tartalmaznia kell legalább egy nagybetűt, egy kisbetűt, és egy számot.
3. **"Emlékezz rám"** opció _(opcionális)_
   - Jelölőnégyzet, amely lehetőséget ad a felhasználónak, hogy megjegyeztesse a böngészővel a felhasználónevét.

Az űrlap POST metódussal továbbítsa az adatokat ugyanarra az oldalra (`login.php`), ahol a PHP kód fogadja és feldolgozza azokat.

---

#### **2. Feladat: Adatok validálása és szűrése**

- Validálási szabályok:
  - A felhasználónév csak alfanumerikus karakterekből állhat.  
    (Használj reguláris kifejezést, pl.: `preg_match('/^[a-zA-Z0-9]+$/', $username)`.)
  - A jelszó feleljen meg a fentiekben leírt biztonsági követelményeknek.
- Szűrés:
  - Használj `trim()` függvényt a mezők elején és végén lévő szóközök eltávolítására.
  - Szűrd meg az adatokat az XSS támadások ellen (pl. `htmlspecialchars()` vagy `filter_input()`).

Hibás adatbevitel esetén jelenítsd meg a hibát az űrlap fölött. Példa:

```html
<div style="color: red;">
  A felhasználónév csak alfanumerikus karaktereket tartalmazhat, és legalább 5
  karakter hosszúnak kell lennie!
</div>
```

---

#### **3. Feladat: Szeánszkezelés**

1. **Szeánsz elindítása**:
   - Az érvényes adatok feldolgozása után mentett el a felhasználó adatait egy szeánsz változóba:
     ```php
     $_SESSION['username'] = $username;
     ```
2. **Felhasználó átirányítása**:
   - A bejelentkezés után irányítsd át a felhasználót a **`profile.php`** oldalra:
     ```php
     header('Location: profile.php');
     exit();
     ```

---

#### **4. Feladat: Sütik kezelése**

1. Ha a felhasználó kijelölte a "Emlékezz rám" opciót, tárold a felhasználónevét sütiben:
   ```php
   setcookie('username', $username, time() + (7 * 24 * 60 * 60)); // 7 napos sütik
   ```
2. A **`login.php`** oldalon ellenőrizd, hogy a süti létezik-e, és automatikusan töltsd be az értékét az űrlap mezőjébe:
   ```php
   $savedUsername = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';
   ```

---

#### **5. Feladat: Kilépés funkció**

1. Hozz létre egy **`logout.php`** oldalt, amely:
   - Lezárja a szeánszot:
     ```php
     session_start();
     session_destroy();
     ```
   - Törli a sütiket:
     ```php
     setcookie('username', '', time() - 3600);
     ```
   - Visszairányítja a felhasználót a bejelentkezési oldalra.

---
