Yii2 Serialized Attributes Behavior
===================================

This Yii2 model behavior allows you to store arrays in attributes.
To attach the behavior put the following code in your model:
```php
    public function behaviors()
   	{
   		return [
   			'serializedAttributes' => [
   				'class' => SerializedAttributes::className(),
   				
   				// Define the attributes you want to be serialized
                'attributes' => ['serializedData', 'moreSerializedData'],
                
                // Enable this option if your DB is not in UTF-8
                // (more info at http://www.jackreichert.com/2014/02/02/handling-a-php-unserialize-offset-error/)
                // 'encode' => true,
   			],
   		];
   	}
```
