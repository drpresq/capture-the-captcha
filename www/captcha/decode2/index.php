<?php
    $command = escapeshellcmd("python crack_test.py");
    $output = shell_exec($command);
    function printLines($array){
        foreach($array as $line){
            echo $line."<br>";
        }
    }
?>
<html>
<head>
</head>
<body>
    <table><tr>
    <td width="50%" style="background:#333333; color:#ffffff; font-size:120%">
        <? printLines($output = explode("\n", $output)); ?>
    </td>
    <td width="50%" valign="top" style="font-size:120%">
    
    <!-- HTML generated using hilite.me -->
    <div style="background: #ffffff; overflow:auto;width:auto;border:solid gray;border-width:.1em .1em .1em .8em;padding:.2em .6em;">
    <pre style="margin: 0; line-height: 125%"><span style="color: #008800; font-weight: bold">from</span><span style="color: #0e84b5; font-weight: bold">PIL</span> <span style="color: #008800; font-weight: bold">import</span> Image
    <span style="color: #008800; font-weight: bold">import</span> <span style="color: #0e84b5; font-weight: bold">hashlib</span>
    <span style="color: #008800; font-weight: bold">import</span> <span style="color: #0e84b5; font-weight: bold">time</span>
    <span style="color: #008800; font-weight: bold">import</span> <span style="color: #0e84b5; font-weight: bold">os</span><span style="color: #333333">,</span> <span style="color: #0e84b5; font-weight: bold">sys</span>


    <span style="color: #008800; font-weight: bold">import</span> <span style="color: #0e84b5; font-weight: bold">math</span>

<span style="color: #008800; font-weight: bold">class</span> <span style="color: #BB0066; font-weight: bold">VectorCompare</span>:
  <span style="color: #008800; font-weight: bold">def</span> <span style="color: #0066BB; font-weight: bold">magnitude</span>(<span style="color: #007020">self</span>,concordance):
    total <span style="color: #333333">=</span> <span style="color: #0000DD; font-weight: bold">0</span>
    <span style="color: #008800; font-weight: bold">for</span> word,count <span style="color: #000000; font-weight: bold">in</span> concordance<span style="color: #333333">.</span>iteritems():
      total <span style="color: #333333">+=</span> count <span style="color: #333333">**</span> <span style="color: #0000DD; font-weight: bold">2</span>
    <span style="color: #008800; font-weight: bold">return</span> math<span style="color: #333333">.</span>sqrt(total)

  <span style="color: #008800; font-weight: bold">def</span> <span style="color: #0066BB; font-weight: bold">relation</span>(<span style="color: #007020">self</span>,concordance1, concordance2):
    relevance <span style="color: #333333">=</span> <span style="color: #0000DD; font-weight: bold">0</span>
    topvalue <span style="color: #333333">=</span> <span style="color: #0000DD; font-weight: bold">0</span>
    <span style="color: #008800; font-weight: bold">for</span> word, count <span style="color: #000000; font-weight: bold">in</span> concordance1<span style="color: #333333">.</span>iteritems():
      <span style="color: #008800; font-weight: bold">if</span> concordance2<span style="color: #333333">.</span>has_key(word):
        topvalue <span style="color: #333333">+=</span> count <span style="color: #333333">*</span> concordance2[word]
    <span style="color: #008800; font-weight: bold">return</span> topvalue <span style="color: #333333">/</span> (<span style="color: #007020">self</span><span style="color: #333333">.</span>magnitude(concordance1) <span style="color: #333333">*</span> <span style="color: #007020">self</span><span style="color: #333333">.</span>magnitude(concordance2))



<span style="color: #008800; font-weight: bold">def</span> <span style="color: #0066BB; font-weight: bold">buildvector</span>(im):
  d1 <span style="color: #333333">=</span> {}

  count <span style="color: #333333">=</span> <span style="color: #0000DD; font-weight: bold">0</span>
  <span style="color: #008800; font-weight: bold">for</span> i <span style="color: #000000; font-weight: bold">in</span> im<span style="color: #333333">.</span>getdata():
    d1[count] <span style="color: #333333">=</span> i
    count <span style="color: #333333">+=</span> <span style="color: #0000DD; font-weight: bold">1</span>

  <span style="color: #008800; font-weight: bold">return</span> d1

v <span style="color: #333333">=</span> VectorCompare()


iconset <span style="color: #333333">=</span> [<span style="background-color: #fff0f0">&#39;0&#39;</span>,<span style="background-color: #fff0f0">&#39;1&#39;</span>,<span style="background-color: #fff0f0">&#39;2&#39;</span>,<span style="background-color: #fff0f0">&#39;3&#39;</span>,<span style="background-color: #fff0f0">&#39;4&#39;</span>,<span style="background-color: #fff0f0">&#39;5&#39;</span>,<span style="background-color: #fff0f0">&#39;6&#39;</span>,<span style="background-color: #fff0f0">&#39;7&#39;</span>,<span style="background-color: #fff0f0">&#39;8&#39;</span>,<span style="background-color: #fff0f0">&#39;9&#39;</span>,<span style="background-color: #fff0f0">&#39;0&#39;</span>,<span style="background-color: #fff0f0">&#39;a&#39;</span>,<span style="background-color: #fff0f0">&#39;b&#39;</span>,<span style="background-color: #fff0f0">&#39;c&#39;</span>,<span style="background-color: #fff0f0">&#39;d&#39;</span>,<span style="background-color: #fff0f0">&#39;e&#39;</span>,<span style="background-color: #fff0f0">&#39;f&#39;</span>,<span style="background-color: #fff0f0">&#39;g&#39;</span>,<span style="background-color: #fff0f0">&#39;h&#39;</span>,<span style="background-color: #fff0f0">&#39;i&#39;</span>,<span style="background-color: #fff0f0">&#39;j&#39;</span>,<span style="background-color: #fff0f0">&#39;k&#39;</span>,<span style="background-color: #fff0f0">&#39;l&#39;</span>,<span style="background-color: #fff0f0">&#39;m&#39;</span>,<span style="background-color: #fff0f0">&#39;n&#39;</span>,<span style="background-color: #fff0f0">&#39;o&#39;</span>,<span style="background-color: #fff0f0">&#39;p&#39;</span>,<span style="background-color: #fff0f0">&#39;q&#39;</span>,<span style="background-color: #fff0f0">&#39;r&#39;</span>,<span style="background-color: #fff0f0">&#39;s&#39;</span>,<span style="background-color: #fff0f0">&#39;t&#39;</span>,<span style="background-color: #fff0f0">&#39;u&#39;</span>,<span style="background-color: #fff0f0">&#39;v&#39;</span>,<span style="background-color: #fff0f0">&#39;w&#39;</span>,<span style="background-color: #fff0f0">&#39;x&#39;</span>,<span style="background-color: #fff0f0">&#39;y&#39;</span>,<span style="background-color: #fff0f0">&#39;z&#39;</span>]


imageset <span style="color: #333333">=</span> []

<span style="color: #008800; font-weight: bold">for</span> letter <span style="color: #000000; font-weight: bold">in</span> iconset:
  <span style="color: #008800; font-weight: bold">for</span> img <span style="color: #000000; font-weight: bold">in</span> os<span style="color: #333333">.</span>listdir(<span style="background-color: #fff0f0">&#39;./iconset/</span><span style="background-color: #eeeeee">%s</span><span style="background-color: #fff0f0">/&#39;</span><span style="color: #333333">%</span>(letter)):
    temp <span style="color: #333333">=</span> []
    <span style="color: #008800; font-weight: bold">if</span> img <span style="color: #333333">!=</span> <span style="background-color: #fff0f0">&quot;Thumbs.db&quot;</span>: <span style="color: #888888"># windows check...</span>
      temp<span style="color: #333333">.</span>append(buildvector(Image<span style="color: #333333">.</span>open(<span style="background-color: #fff0f0">&quot;./iconset/</span><span style="background-color: #eeeeee">%s</span><span style="background-color: #fff0f0">/</span><span style="background-color: #eeeeee">%s</span><span style="background-color: #fff0f0">&quot;</span><span style="color: #333333">%</span>(letter,img))))
    imageset<span style="color: #333333">.</span>append({letter:temp})

correctcount <span style="color: #333333">=</span> <span style="color: #0000DD; font-weight: bold">0</span>
wrongcount <span style="color: #333333">=</span> <span style="color: #0000DD; font-weight: bold">0</span>


<span style="color: #008800; font-weight: bold">for</span> filename <span style="color: #000000; font-weight: bold">in</span> os<span style="color: #333333">.</span>listdir(<span style="background-color: #fff0f0">&#39;./examples/&#39;</span>):
  <span style="color: #008800; font-weight: bold">try</span>:
    im <span style="color: #333333">=</span> Image<span style="color: #333333">.</span>open(<span style="background-color: #fff0f0">&quot;./examples/</span><span style="background-color: #eeeeee">%s</span><span style="background-color: #fff0f0">&quot;</span><span style="color: #333333">%</span>(filename))
  <span style="color: #008800; font-weight: bold">except</span>:
    <span style="color: #008800; font-weight: bold">break</span>
  
  <span style="color: #008800; font-weight: bold">print</span> <span style="background-color: #fff0f0">&quot;&quot;</span>
  <span style="color: #008800; font-weight: bold">print</span> <span style="background-color: #fff0f0">&quot;&lt;img src=&#39;./examples/&quot;</span><span style="color: #333333">+</span>filename<span style="color: #333333">+</span><span style="background-color: #fff0f0">&quot;&#39; /&gt;&quot;</span>
  <span style="color: #008800; font-weight: bold">print</span> <span style="background-color: #fff0f0">&quot;&quot;</span>
  <span style="color: #008800; font-weight: bold">print</span> filename

  im2 <span style="color: #333333">=</span> Image<span style="color: #333333">.</span>new(<span style="background-color: #fff0f0">&quot;P&quot;</span>,im<span style="color: #333333">.</span>size,<span style="color: #0000DD; font-weight: bold">255</span>)
  im <span style="color: #333333">=</span> im<span style="color: #333333">.</span>convert(<span style="background-color: #fff0f0">&quot;P&quot;</span>)
  temp <span style="color: #333333">=</span> {}

  <span style="color: #008800; font-weight: bold">for</span> x <span style="color: #000000; font-weight: bold">in</span> <span style="color: #007020">range</span>(im<span style="color: #333333">.</span>size[<span style="color: #0000DD; font-weight: bold">1</span>]):
    <span style="color: #008800; font-weight: bold">for</span> y <span style="color: #000000; font-weight: bold">in</span> <span style="color: #007020">range</span>(im<span style="color: #333333">.</span>size[<span style="color: #0000DD; font-weight: bold">0</span>]):
      pix <span style="color: #333333">=</span> im<span style="color: #333333">.</span>getpixel((y,x))
      temp[pix] <span style="color: #333333">=</span> pix
      <span style="color: #008800; font-weight: bold">if</span> pix <span style="color: #333333">==</span> <span style="color: #0000DD; font-weight: bold">220</span> <span style="color: #000000; font-weight: bold">or</span> pix <span style="color: #333333">==</span> <span style="color: #0000DD; font-weight: bold">227</span>: <span style="color: #888888"># these are the numbers to get</span>
        im2<span style="color: #333333">.</span>putpixel((y,x),<span style="color: #0000DD; font-weight: bold">0</span>)
    
  inletter <span style="color: #333333">=</span> <span style="color: #007020">False</span>
  foundletter<span style="color: #333333">=</span><span style="color: #007020">False</span>
  start <span style="color: #333333">=</span> <span style="color: #0000DD; font-weight: bold">0</span>
  end <span style="color: #333333">=</span> <span style="color: #0000DD; font-weight: bold">0</span>

  letters <span style="color: #333333">=</span> []

  <span style="color: #008800; font-weight: bold">for</span> y <span style="color: #000000; font-weight: bold">in</span> <span style="color: #007020">range</span>(im2<span style="color: #333333">.</span>size[<span style="color: #0000DD; font-weight: bold">0</span>]): <span style="color: #888888"># slice across</span>
    <span style="color: #008800; font-weight: bold">for</span> x <span style="color: #000000; font-weight: bold">in</span> <span style="color: #007020">range</span>(im2<span style="color: #333333">.</span>size[<span style="color: #0000DD; font-weight: bold">1</span>]): <span style="color: #888888"># slice down</span>
      pix <span style="color: #333333">=</span> im2<span style="color: #333333">.</span>getpixel((y,x))
      <span style="color: #008800; font-weight: bold">if</span> pix <span style="color: #333333">!=</span> <span style="color: #0000DD; font-weight: bold">255</span>:
        inletter <span style="color: #333333">=</span> <span style="color: #007020">True</span>

    <span style="color: #008800; font-weight: bold">if</span> foundletter <span style="color: #333333">==</span> <span style="color: #007020">False</span> <span style="color: #000000; font-weight: bold">and</span> inletter <span style="color: #333333">==</span> <span style="color: #007020">True</span>:
      foundletter <span style="color: #333333">=</span> <span style="color: #007020">True</span>
      start <span style="color: #333333">=</span> y

    <span style="color: #008800; font-weight: bold">if</span> foundletter <span style="color: #333333">==</span> <span style="color: #007020">True</span> <span style="color: #000000; font-weight: bold">and</span> inletter <span style="color: #333333">==</span> <span style="color: #007020">False</span>:
      foundletter <span style="color: #333333">=</span> <span style="color: #007020">False</span>
      end <span style="color: #333333">=</span> y
      letters<span style="color: #333333">.</span>append((start,end))


    inletter<span style="color: #333333">=</span><span style="color: #007020">False</span>

  count <span style="color: #333333">=</span> <span style="color: #0000DD; font-weight: bold">0</span>
  guessword <span style="color: #333333">=</span> <span style="background-color: #fff0f0">&quot;&quot;</span>
  <span style="color: #008800; font-weight: bold">for</span> letter <span style="color: #000000; font-weight: bold">in</span> letters:
    m <span style="color: #333333">=</span> hashlib<span style="color: #333333">.</span>md5()
    im3 <span style="color: #333333">=</span> im2<span style="color: #333333">.</span>crop(( letter[<span style="color: #0000DD; font-weight: bold">0</span>] , <span style="color: #0000DD; font-weight: bold">0</span>, letter[<span style="color: #0000DD; font-weight: bold">1</span>],im2<span style="color: #333333">.</span>size[<span style="color: #0000DD; font-weight: bold">1</span>] ))

    guess <span style="color: #333333">=</span> []

    <span style="color: #008800; font-weight: bold">for</span> image <span style="color: #000000; font-weight: bold">in</span> imageset:
      <span style="color: #008800; font-weight: bold">for</span> x,y <span style="color: #000000; font-weight: bold">in</span> image<span style="color: #333333">.</span>iteritems():
        <span style="color: #008800; font-weight: bold">if</span> <span style="color: #007020">len</span>(y) <span style="color: #333333">!=</span> <span style="color: #0000DD; font-weight: bold">0</span>:
          guess<span style="color: #333333">.</span>append( ( v<span style="color: #333333">.</span>relation(y[<span style="color: #0000DD; font-weight: bold">0</span>],buildvector(im3)),x) )

    guess<span style="color: #333333">.</span>sort(reverse<span style="color: #333333">=</span><span style="color: #007020">True</span>)
    <span style="color: #008800; font-weight: bold">print</span> <span style="background-color: #fff0f0">&quot;&quot;</span>,guess[<span style="color: #0000DD; font-weight: bold">0</span>]
    guessword <span style="color: #333333">=</span> <span style="background-color: #fff0f0">&quot;</span><span style="background-color: #eeeeee">%s%s</span><span style="background-color: #fff0f0">&quot;</span><span style="color: #333333">%</span>(guessword,guess[<span style="color: #0000DD; font-weight: bold">0</span>][<span style="color: #0000DD; font-weight: bold">1</span>])

    count <span style="color: #333333">+=</span> <span style="color: #0000DD; font-weight: bold">1</span>
  <span style="color: #008800; font-weight: bold">if</span> guessword <span style="color: #333333">==</span> filename[:<span style="color: #333333">-</span><span style="color: #0000DD; font-weight: bold">4</span>]:
    correctcount <span style="color: #333333">+=</span> <span style="color: #0000DD; font-weight: bold">1</span>
  <span style="color: #008800; font-weight: bold">else</span>:
    wrongcount <span style="color: #333333">+=</span> <span style="color: #0000DD; font-weight: bold">1</span>


<span style="color: #008800; font-weight: bold">print</span> <span style="background-color: #fff0f0">&quot;=======================&quot;</span>
correctcount <span style="color: #333333">=</span> <span style="color: #007020">float</span>(correctcount)
wrongcount <span style="color: #333333">=</span> <span style="color: #007020">float</span>(wrongcount)
<span style="color: #008800; font-weight: bold">print</span> <span style="background-color: #fff0f0">&quot;Correct Guesses - &quot;</span>,correctcount
<span style="color: #008800; font-weight: bold">print</span> <span style="background-color: #fff0f0">&quot;Wrong Guesses - &quot;</span>,wrongcount
<span style="color: #008800; font-weight: bold">print</span> <span style="background-color: #fff0f0">&quot;Percentage Correct - &quot;</span>, correctcount<span style="color: #333333">/</span>(correctcount<span style="color: #333333">+</span>wrongcount)<span style="color: #333333">*</span><span style="color: #6600EE; font-weight: bold">100.00</span>
<span style="color: #008800; font-weight: bold">print</span> <span style="background-color: #fff0f0">&quot;Percentage Wrong - &quot;</span>, wrongcount<span style="color: #333333">/</span>(correctcount<span style="color: #333333">+</span>wrongcount)<span style="color: #333333">*</span><span style="color: #6600EE; font-weight: bold">100.00</span>
</pre></div>

    
    </td>
    <tr></table>
</body>
</html>