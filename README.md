## Book Plugin for PMMP5

書いた本の内容を保存してあとで取り出したり、他人共有したりできます。
ほとんどの操作がフォーム内で完結するため、直観的に操作できます。

| コマンド                           | 効果                                                   | デフォルト権限 |
|--------------------------------|:-----------------------------------------------------|---------|
| /book                          | フォームを用いて本を保存したり取り出したり出来ます                            | OPのみ    |
| /pushbook                      | 手に持っている本(本と羽ペン/署名済みの本)を保存できます                        | OPのみ    |
| /pullbook                      | フォームを用いて本を取り出します                                     | OPのみ    |
| /pullbook <本のID> [true\|false] | 自分が書いた本を取得します。2つめにtrueを指定すると署名された本ではなく本と羽ペンの状態で取得します | OPのみ    |
| /pullbook <本のID> <本の作者>        | 他人が書いた本を取得します。本の作者が、その本を他人に公開するよう設定している必要があります       | OPのみ    |