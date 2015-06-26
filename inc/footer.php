<footer class="footer" role="contentinfo" >
    <div class="panel-footer" >
    	<table width="100%">
    		<tr>
    			<td>
    				<p class="text-left">
    					<?if (isset($_SESSION["userName"])): ?>
    						Usuario : <?=$_SESSION["userName"]?>  
    					<? endif; ?>
    				</p>
    			</td>
    			<td>
    				<p class="text-right">
    					<?if (isset($_SESSION["role"])): ?>
    						Rol : <?=$_SESSION["role"]?>  
    					<? endif; ?>
    				</p>
    			</td>
    		</tr>
    	</table>
    </div>
</footer>