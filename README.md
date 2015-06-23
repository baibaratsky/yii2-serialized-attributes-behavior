Yii2 Serialized Attributes Behavior
===================================

This Yii2 model behavior allows you to store arrays in attributes.
To attach the behavior put the following code in your model:
```php
    public function behaviors()
   	{
   		return [
   			'slug' => [
   				'class' => SerializedAttributes::className(),
   				
   				// Define the attributes you want to be serialized
                'attributes' => ['serializedData', 'moreSerializedData'],
   			],
   		];
   	}
```
