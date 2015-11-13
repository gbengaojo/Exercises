   <?php if ($this->messages) : ?>
      <?php foreach ($this->messages as $message) : ?>
         <div class="flashmessages"><?php echo $message ?></div>
      <?php endforeach ?>
   <?php endif ?>
   

   <div id="nav">
      <a href="/admin/games">Games</a> | <a href="/admin/questions">Questions</a> | <a href="/admin/answers">Answers</a> | <a href="/admin/clues">Clues</a>
   </div>
