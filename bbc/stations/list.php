<? ob_start(); ?>

<meta charset="utf-8">
<title>BBC Radio Latest Tracks XSPF</title>

<style>body { font-family: sans-serif; }</style>

<p>Generate a XSPF playlist for the latest tracks played on a BBC Radio station.</p>

<form>
  <label>Station identifier <input type="text" pattern="^[a-z]+$" name="series" placeholder="Enter the identifier of a BBC Radio station" size="30"></label>
  <input type="submit" value="Generate XSPF">
</form>

<? ob_end_flush(); ?>

<h2>Stations</h2>

<p>Copy one of these links and choose "Load XSPF" in <a href="http://www.tomahawk-player.org/">Tomahawk</a> (select "automatically update" to always get the latest tracks):</p>

<?
$stations = array(
  'radio1' => 'Radio 1',
  '1xtra' => 'Radio 1Xtra',
  'radio2' => 'Radio 2',
  'radio3' => 'Radio 3',
  '6music' => '6 Music',
);
?>

<ul>
<? foreach ($stations as $station => $title): ?>
  <li><a href="?station=<?= htmlspecialchars($station, ENT_QUOTES, 'UTF-8'); ?>"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></a></li>
<? endforeach; ?>
</ul>

<div><a href="http://www.bbc.co.uk/radio/stations">All BBC Radio stations</a></div>
