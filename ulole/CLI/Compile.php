<?php
namespace ulole\CLI;

class Compile {
    
    public static function compileDir($config, $indir) {
        $conf = json_decode(file_get_contents($config));
        foreach ($conf as $val => $key) {
            $out = "";
            $forout = "";
            foreach ($key as $file) {
                 $out .= file_get_contents($indir."/".$file);
            }
            file_put_contents("public/".$val, $out);
        }
    }

    public static function compileViews($dir, $enddir) {
        $replaceArray = [
            "{[{"=>'<?php echo htmlspecialchars(',
            "}]}"=>'); ?>',
            "{{"=>'<?php echo (',
            "}}"=>'); ?>',
            
            // STARTS
            "@if(("=>'<?php if(',
            "@elseif(("=>'<?php elseif(',
            "@foreach(("=>'<?php foreach(',
            "@for(("=>'<?php for(',
            "@while(("=>'<?php while(',
            
            "@import(("=>"<?php import(",
            "@view(("=>"<?php view(",
            "@template(("=>"<?php tmpl(",

            "))!"=>"); ?>",
            "))#"=>"):?>",
            '@else'=>"<?php else: ?>",
            
            // ENDS
            '@endif'=>"<?php endif; ?>",
            '@endforeach'=>"<?php endforeach; ?>",
            '@endwhile'=>"<?php endwhile; ?>",
            
            '<?#'=>'<?php',
            '#?>'=>'?>'
        ];

        $files = scandir($dir);
        foreach($files as $file) {
            if ($file != ".." && $file != ".") {
                if (is_dir($dir."/".$file)){
                    if(!\is_dir($enddir."/".$file))
                        \mkdir($enddir."/".$file);
                    self::compileViews($dir."/".$file, $enddir."/".$file);
                } elseif (strpos($file, "view.php")) {
                    \file_put_contents($enddir."/".str_replace(".view.php", ".php", $file), \ulole\core\classes\Replace::replaceByArray($replaceArray, \file_get_contents($dir."/".$file)));
                    echo "\nview.php renderer: rendered: ".$enddir.$dir."/".$file." into ".$enddir."/".str_replace(".view.php", ".php", $file);
                }
            }        
        }
    } 
}

