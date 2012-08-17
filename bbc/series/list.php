<? ob_start(); ?>

<meta charset="utf-8">
<title>BBC Radio Latest Episode XSPF</title>

<style>body { font-family: sans-serif; }</style>

<p>Generate a XSPF playlist for the latest episode of a BBC Radio series.</p>

<form>
  <label>Series PID <input type="text" pattern="^[a-z0-9]+$" name="series" placeholder="Enter the PID of a BBC Radio series" size="30"></label>
  <input type="submit" value="Generate XSPF">
</form>

<? ob_end_flush(); ?>

<? $brands = json_decode(file_get_contents('http://www.bbc.co.uk/programmes/genres/music/player.json'), true); ?>

<? if ($brands): ?>

<h2>Series</h2>

<p>Copy one of these links and choose "Load XSPF" in <a href="http://www.tomahawk-player.org/">Tomahawk</a> (select "automatically update" to always get the latest episode):</p>

<ul>
<? foreach ($brands['category_slice']['programmes'] as $series): ?>
  <li><a href="?series=<?= htmlspecialchars($series['pid'], ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($series['title'], ENT_QUOTES, 'UTF-8') ?></a></li>
<? endforeach; ?>
</ul>

<? endif; ?>

<div><a href="http://www.bbc.co.uk/programmes/genres/music/player">All BBC Music Shows</a></div>
