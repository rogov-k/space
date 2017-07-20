<div class="block block--info">
  <h2>General information</h2>
  <div class="info-list font">
    <div class="info--item">
      <label>Name: </label>
      <span><?php echo $object['name']; ?></span>
    </div>
    <div class="info--item">
      <label>Country: </label>
      <span><?php echo $object['country_id']; ?></span>
    </div>
    <div class="info--item">
      <label>Launch&nbsp;data: </label>
      <span><?php echo $object['launch_date']; ?></span>
    </div>
    <div class="info--item">
      <label>Revolution&nbsp;number: </label>
      <span><?php echo $object['revolution_number']; ?></span>
    </div>
  </div>
</div>
<div class="block block--info block--info__hover" data-id="<?php echo $object['satellite_id']; ?>">
  <h2>Object parameters</h2>
  <div class="info-list font">
    <div class="info--item grafic" data-grafic="ft_derivative">
      <label>1'st&nbsp;derivative: </label>
      <span><?php echo $object['ft_derivative']; ?></span>
    </div>
    <div class="info--item grafic" data-grafic="st_derivative">
      <label>2'nd&nbsp;derivative: </label>
      <span><?php echo $object['st_derivative']; ?></span>
    </div>
    <div class="info--item grafic" data-grafic="bstar">
      <label>Bstar: </label>
      <span><?php echo $object['bstar']; ?></span>
    </div>
    <div class="info--item grafic" data-grafic="inclination">
      <label>Inclination: </label>
      <span><?php echo $object['inclination']; ?></span>
    </div>
    <div class="info--item grafic" data-grafic="raan">
      <label>Raan: </label>
      <span><?php echo $object['raan']; ?></span>
    </div>
    <div class="info--item grafic" data-grafic="eccentricity">
      <label>Eccentricity: </label>
      <span><?php echo $object['eccentricity']; ?></span>
    </div>
    <div class="info--item grafic" data-grafic="perigee">
      <label>Argument&nbsp;perigee: </label>
      <span><?php echo $object['perigee']; ?></span>
    </div>
    <div class="info--item grafic" data-grafic="mean_anomaly">
      <label>Mean&nbsp;anomaly: </label>
      <span><?php echo $object['mean_anomaly']; ?></span>
    </div>
    <div class="info--item grafic" data-grafic="mean_motion">
      <label>Mean&nbsp;motion: </label>
      <span><?php echo $object['mean_motion']; ?></span>
    </div> 
  </div>
</div>
<div id="graphic" class="block block--graphic"></div>
<!--div class="block block-api">
  <pre class="font" style="margin: 0;">p[0] = <?php echo deg2rad($object['raan']); ?>;
p[1] = <?php echo deg2rad($object['perigee']); ?>;
p[2] = <?php echo deg2rad($object['mean_anomaly']); ?>;
p[3] = <?php echo deg2rad($object['inclination']); ?>;
p[4] = <?php echo $object['eccentricity']; ?>;
p[5] = <?php echo $object['bstar']; ?>;
p[6] = <?php echo $object['mean_motion']; ?>;
p[7] = <?php echo $object['ft_derivative']; ?>;
p[8] = <?php echo $object['st_derivative']; ?>;</pre>
</div-->