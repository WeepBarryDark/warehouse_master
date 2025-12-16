<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import Heading from '@/components/Heading.vue';
import { useI18n } from 'vue-i18n';
import { Send, Paperclip, X } from 'lucide-vue-next';
import { ref } from 'vue';

const { t } = useI18n();

const form = useForm({
    to: '',
    subject: '',
    message: '',
    priority: 'normal',
});

const attachments = ref<File[]>([]);
const fileInput = ref<HTMLInputElement | null>(null);

const handleFileUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files) {
        attachments.value.push(...Array.from(target.files));
    }
};

const removeAttachment = (index: number) => {
    attachments.value.splice(index, 1);
};

const submit = () => {
    form.post(route('dashboard.messages.send'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            attachments.value = [];
        },
    });
};
</script>

<template>
    <Head :title="t('dashboard.sidebar.send_message')" />

    <div class="space-y-6">
        <Heading>{{ t('dashboard.sidebar.send_message') }}</Heading>

        <Card>
            <CardHeader>
                <CardTitle>Compose Message</CardTitle>
                <CardDescription>Send a message to users or teams</CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="space-y-2">
                        <Label for="to">To *</Label>
                        <Input
                            id="to"
                            v-model="form.to"
                            type="text"
                            required
                            placeholder="Enter recipient email or username"
                        />
                    </div>

                    <div class="space-y-2">
                        <Label for="subject">Subject *</Label>
                        <Input
                            id="subject"
                            v-model="form.subject"
                            type="text"
                            required
                            placeholder="Message subject"
                        />
                    </div>

                    <div class="space-y-2">
                        <Label for="priority">Priority</Label>
                        <select
                            id="priority"
                            v-model="form.priority"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                        >
                            <option value="low">Low</option>
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <Label for="message">Message *</Label>
                        <textarea
                            id="message"
                            v-model="form.message"
                            required
                            rows="8"
                            class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 resize-none"
                            placeholder="Type your message here..."
                        />
                    </div>

                    <!-- Attachments -->
                    <div class="space-y-2">
                        <Label>Attachments</Label>
                        <div class="space-y-2">
                            <div
                                v-for="(file, index) in attachments"
                                :key="index"
                                class="flex items-center justify-between rounded-lg border p-3"
                            >
                                <div class="flex items-center gap-3">
                                    <Paperclip class="h-4 w-4 text-muted-foreground" />
                                    <div>
                                        <p class="text-sm font-medium">{{ file.name }}</p>
                                        <p class="text-xs text-muted-foreground">
                                            {{ (file.size / 1024).toFixed(2) }} KB
                                        </p>
                                    </div>
                                </div>
                                <Button
                                    type="button"
                                    variant="ghost"
                                    size="sm"
                                    @click="removeAttachment(index)"
                                >
                                    <X class="h-4 w-4" />
                                </Button>
                            </div>

                            <Button
                                type="button"
                                variant="outline"
                                size="sm"
                                @click="fileInput?.click()"
                            >
                                <Paperclip class="mr-2 h-4 w-4" />
                                Add Attachment
                            </Button>
                            <input
                                ref="fileInput"
                                type="file"
                                multiple
                                class="hidden"
                                @change="handleFileUpload"
                            />
                        </div>
                    </div>

                    <div class="flex justify-end gap-4">
                        <Button type="button" variant="outline" @click="form.reset()">
                            Discard
                        </Button>
                        <Button type="submit" :disabled="form.processing">
                            <Send class="mr-2 h-4 w-4" />
                            {{ form.processing ? 'Sending...' : 'Send Message' }}
                        </Button>
                    </div>
                </form>
            </CardContent>
        </Card>
    </div>
</template>
