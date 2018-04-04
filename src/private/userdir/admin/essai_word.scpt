FasdUAS 1.101.10   ��   ��    k             l     ��  ��    1 +c--   countSubstring(theText, theSubstring)     � 	 	 V c - -       c o u n t S u b s t r i n g ( t h e T e x t ,   t h e S u b s t r i n g )   
  
 l     ��  ��    N Hd--   Count the number of occurrences of a substring (case-insensitive).     �   � d - -       C o u n t   t h e   n u m b e r   o f   o c c u r r e n c e s   o f   a   s u b s t r i n g   ( c a s e - i n s e n s i t i v e ) .      l     ��  ��    C =a--   theText : string -- the string containing the substring     �   z a - -       t h e T e x t   :   s t r i n g   - -   t h e   s t r i n g   c o n t a i n i n g   t h e   s u b s t r i n g      l     ��  ��    8 2a--   theSubstring : string -- the string to count     �   d a - -       t h e S u b s t r i n g   :   s t r i n g   - -   t h e   s t r i n g   t o   c o u n t      l     ��  ��    9 3r--   integer -- number of occurrences of substring     �   f r - -       i n t e g e r   - -   n u m b e r   o f   o c c u r r e n c e s   o f   s u b s t r i n g      l     ��   !��     6 0x--   countSubstring("abc abc abc", "abc") --> 3    ! � " " ` x - -       c o u n t S u b s t r i n g ( " a b c   a b c   a b c " ,   " a b c " )   - - >   3   # $ # l     �� % &��   % G Au--   ljr (http://applescript.bratis-lover.net/library/string/),     & � ' ' � u - -       l j r   ( h t t p : / / a p p l e s c r i p t . b r a t i s - l o v e r . n e t / l i b r a r y / s t r i n g / ) ,   $  ( ) ( l     �� * +��   * K Eu--   modified from 'Aurelio.net' (http://aurelio.net/doc/as4pp.html)    + � , , � u - -       m o d i f i e d   f r o m   ' A u r e l i o . n e t '   ( h t t p : / / a u r e l i o . n e t / d o c / a s 4 p p . h t m l ) )  - . - i      / 0 / I      �� 1����  0 countsubstring countSubstring 1  2 3 2 o      ���� 0 thetext theText 3  4�� 4 o      ���� 0 thesubstring theSubstring��  ��   0 k     9 5 5  6 7 6 q       8 8 �� 9�� 0 astid ASTID 9 �� :�� 0 thetext theText : �� ;�� 0 thesubstring theSubstring ; ������ 0 i  ��   7  < = < r      > ? > n     @ A @ 1    ��
�� 
txdl A 1     ��
�� 
ascr ? o      ���� 0 astid ASTID =  B�� B Q    9 C D E C k   	 # F F  G H G r   	  I J I o   	 
���� 0 thesubstring theSubstring J n      K L K 1    ��
�� 
txdl L 1   
 ��
�� 
ascr H  M N M r     O P O \     Q R Q l    S���� S I   �� T��
�� .corecnte****       **** T n    U V U 2   ��
�� 
citm V o    ���� 0 thetext theText��  ��  ��   R m    ����  P o      ���� 0 i   N  W X W r      Y Z Y o    ���� 0 astid ASTID Z n      [ \ [ 1    ��
�� 
txdl \ 1    ��
�� 
ascr X  ]�� ] L   ! # ^ ^ o   ! "���� 0 i  ��   D R      �� _ `
�� .ascrerr ****      � **** _ o      ���� 0 emsg eMsg ` �� a��
�� 
errn a o      ���� 0 enum eNum��   E k   + 9 b b  c d c r   + 0 e f e o   + ,���� 0 astid ASTID f n      g h g 1   - /��
�� 
txdl h 1   , -��
�� 
ascr d  i�� i R   1 9�� j k
�� .ascrerr ****      � **** j b   5 8 l m l m   5 6 n n � o o , C a n ' t   c o u n t S u b s t r i n g :   m o   6 7���� 0 emsg eMsg k �� p��
�� 
errn p o   3 4���� 0 enum eNum��  ��  ��   .  q r q l     ��������  ��  ��   r  s�� s l    � t���� t O     � u v u k    � w w  x y x I   	������
�� .miscactvnull��� ��� null��  ��   y  z { z l  
 
��������  ��  ��   {  | } | l  
  ~  � ~ r   
  � � � c   
  � � � m   
  � � � � � F    ( A C   ) �     "d    ( A B   ) �      +    ( B C   ) �      � m    ��
�� 
utxt � o      ���� 0 thetext theText    or to whatever    � � � �    o r   t o   w h a t e v e r }  � � � l   ��������  ��  ��   �  � � � l   �� � ���   � &   on r�cup�re la longueur du text    � � � � @   o n   r � c u p � r e   l a   l o n g u e u r   d u   t e x t �  � � � r     � � � I   �� ���
�� .corecnte****       **** � o    ���� 0 thetext theText��   � o      ���� 0 len   �  � � � l   ��������  ��  ��   �  � � � r    ! � � � n    � � � I    �� �����  0 countsubstring countSubstring �  � � � o    ���� 0 thetext theText �  ��� � m     � � � � �  ) ���  ��   �  f     � o      ���� 0 specialchar specialChar �  � � � l  " "��������  ��  ��   �  � � � l  " "�� � ���   � 2 , on r�cup�re le point de s�lection de d�part    � � � � X   o n   r � c u p � r e   l e   p o i n t   d e   s � l e c t i o n   d e   d � p a r t �  � � � r   " ) � � � n   " ' � � � 1   % '��
�� 
2903 � 1   " %��
�� 
sele � o      ���� 0 selstart selStart �  � � � l  * *��������  ��  ��   �  � � � l  * *�� � ���   � 7 1 on cr�� le range dans le quel on ins�re le texte    � � � � b   o n   c r � �   l e   r a n g e   d a n s   l e   q u e l   o n   i n s � r e   l e   t e x t e �  � � � r   * ; � � � I  * 7�� � �
�� .sWRD1430null���     docu � 1   * -��
�� 
1003 � �� � �
�� 
5263 � l  . / ����� � o   . /���� 0 selstart selStart��  ��   � �� ���
�� 
5264 � l  0 1 ����� � o   0 1���� 0 selstart selStart��  ��  ��   � o      ���� 0 	textrange 	textRange �  � � � l  < <��������  ��  ��   �  � � � l  < <�� � ���   �   on ins�re le texte    � � � � &   o n   i n s � r e   l e   t e x t e �  � � � r   < E � � � o   < =���� 0 thetext theText � n       � � � 1   @ D��
�� 
1650 � o   = @���� 0 	textrange 	textRange �  � � � l  F F��������  ��  ��   �  � � � l  F F�� � ���   � , &insert text theText at after textRange    � � � � L i n s e r t   t e x t   t h e T e x t   a t   a f t e r   t e x t R a n g e �  � � � l  F F��������  ��  ��   �  � � � l  F F�� � ���   � ) #set content of selection to theText    � � � � F s e t   c o n t e n t   o f   s e l e c t i o n   t o   t h e T e x t �  � � � l  F F��������  ��  ��   �  � � � l  F F�� � ���   �   on s�lectionne le texte    � � � � 0   o n   s � l e c t i o n n e   l e   t e x t e �  � � � r   F [ � � � I  F W�� � �
�� .sWRD1430null���     docu � 1   F I��
�� 
1003 � �� � �
�� 
5263 � l  J K ���~ � o   J K�}�} 0 selstart selStart�  �~   � �| ��{
�| 
5264 � l  L Q ��z�y � [   L Q � � � [   L O � � � o   L M�x�x 0 selstart selStart � o   M N�w�w 0 len   � o   O P�v�v 0 specialchar specialChar�z  �y  �{   � o      �u�u 0 	textrange 	textRange �  � � � I  \ c�t ��s
�t .miscslctnull���    obj  � o   \ _�r�r 0 	textrange 	textRange�s   �  � � � l  d d�q�p�o�q  �p  �o   �  � � � l  d d�n � ��n   �   on peut cr�er    � � � �    o n   p e u t   c r � e r �  � � � I  d {�m�l �
�m .sWRD14BBnull��� ��� null�l   � �k � 
�k 
14BC � l 	 h o�j�i l 
 h o�h�g l  h o�f�e l  h o�d�c n   h o 1   k o�b
�b 
wTxR l  h k�a�` 1   h k�_
�_ 
sele�a  �`  �d  �c  �f  �e  �h  �g  �j  �i    �^�]
�^ 
14BA l  r u	�\�[	 1   r u�Z
�Z 
sele�\  �[  �]   � 

 l  | |�Y�X�W�Y  �X  �W    r   | � n   | � 4    ��V
�V 
o112 m   � ��U�U  l  | �T�S 1   | �R
�R 
sele�T  �S   o      �Q�Q 0 themathobject theMathObject  l  � ��P�O�N�P  �O  �N    I  � ��M�L
�M .sWRD14ADnull���     o112 o   � ��K�K 0 themathobject theMathObject�L    l  � ��J�I�H�J  �I  �H    n   � � 1   � ��G
�G 
1650 l  � ��F�E n   � � !  m   � ��D
�D 
w122! o   � ��C�C 0 themathobject theMathObject�F  �E   "#" l  � ��B�A�@�B  �A  �@  # $%$ r   � �&'& n   � �()( m   � ��?
�? 
w122) o   � ��>�> 0 themathobject theMathObject' o      �=�= 0 myrange myRange% *+* l  � ��<�;�:�<  �;  �:  + ,-, r   � �./. I  � ��901
�9 .sTXTwMeRnull���     w1220 o   � ��8�8 0 myrange myRange1 �723
�7 
wByu2 m   � ��6
�6 e129 3 �54�4
�5 
52694 m   � ��3�3 �4  / o      �2�2 0 orange oRange- 565 l  � ��1�0�/�1  �0  �/  6 787 I  � ��.9�-
�. .sWRD3026null���     WSoj9 1   � ��,
�, 
sele�-  8 :�+: l  � ��*�)�(�*  �)  �(  �+   v m     ;;�                                                                                  MSWD  alis    J  Macintosh HD SSD               BD ����Microsoft Word.app                                             ����            ����  
 cu             Applications  "/:Applications:Microsoft Word.app/  &  M i c r o s o f t   W o r d . a p p  "  M a c i n t o s h   H D   S S D  Applications/Microsoft Word.app   / ��  ��  ��  ��       �'<=>�'  < �&�%�&  0 countsubstring countSubstring
�% .aevtoappnull  �   � ****= �$ 0�#�"?@�!�$  0 countsubstring countSubstring�# � A�  A  ��� 0 thetext theText� 0 thesubstring theSubstring�"  ? ������� 0 thetext theText� 0 thesubstring theSubstring� 0 astid ASTID� 0 i  � 0 emsg eMsg� 0 enum eNum@ �����B� n
� 
ascr
� 
txdl
� 
citm
� .corecnte****       ****� 0 emsg eMsgB ���
� 
errn� 0 enum eNum�  
� 
errn�! :��,E�O ���,FO��-j kE�O���,FO�W X  ���,FO)�l�%> �C��DE�
� .aevtoappnull  �   � ****C k     �FF  s�
�
  �  �  D  E $;�	 ����� ������ ����������������������������������������������
�	 .miscactvnull��� ��� null
� 
utxt� 0 thetext theText
� .corecnte****       ****� 0 len  �  0 countsubstring countSubstring� 0 specialchar specialChar
� 
sele
� 
2903�  0 selstart selStart
�� 
1003
�� 
5263
�� 
5264�� 
�� .sWRD1430null���     docu�� 0 	textrange 	textRange
�� 
1650
�� .miscslctnull���    obj 
�� 
14BC
�� 
wTxR
�� 
14BA
�� .sWRD14BBnull��� ��� null
�� 
o112�� 0 themathobject theMathObject
�� .sWRD14ADnull���     o112
�� 
w122�� 0 myrange myRange
�� 
wByu
�� e129 
�� 
5269
�� .sTXTwMeRnull���     w122�� 0 orange oRange
�� .sWRD3026null���     WSoj� �� �*j O��&E�O�j E�O)��l+ E�O*�,�,E�O*�,����a  E` O�_ a ,FO*�,������a  E` O_ j O*a *�,a ,a *�,a  O*�,a k/E` O_ j O_ a ,a ,EO_ a ,E` O_ a a a  la  !E` "O*�,j #OPU ascr  ��ޭ