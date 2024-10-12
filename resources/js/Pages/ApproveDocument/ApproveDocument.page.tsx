import Header from "@/Components/Header/Header";
import { PageProps } from "@/types";
import ApproveIcon from "./ApproveIcon";
import { Avatar, Button, Card, Flex, Group, Stack, Text, Textarea } from "@mantine/core";
import { Head, useForm } from "@inertiajs/react";
import { IconDownload, IconFileTypePdf, IconFolder } from "@tabler/icons-react";
import { notifications } from "@mantine/notifications";

const ApproveDocumentPage: React.FC<PageProps> = ({ auth, notification }) => {
    const { data, post, processing } = useForm({
        file_id: "",
        destination_id: "",
        notification_id: "",
        action: "",
    });

    const handleDocumentAction = (action: "approved" | "rejected") => {
        data.notification_id = notification.id;
        data.file_id = notification.data.file_id;
        data.destination_id = notification.data.move_to;
        data.action = action;

        post(route("approval.result"), {
            data: { ...data, action },
            onSuccess: () => {
                notifications.show({
                    message: `Document ${action} successfully`,
                    color: action === "approved" ? "green" : "red",
                });
            },
            onError: () => {
                notifications.show({
                    message: "Something went wrong",
                    color: "red",
                });
            },
        });
    };

    return (
        <>
            <Head title="Approve Document" />
            <Header user={auth.user} />
            <Flex mih={100} justify="center" mb={48}>
                <div>
                    <Stack gap={16} align="center" mb={16}>
                        <ApproveIcon />

                        <Text fw={500} size="xl">
                            {notification.data.message}
                        </Text>
                    </Stack>

                    <Stack gap={24}>
                        <Group>
                            <IconFolder color="none" fill="gray" />
                            <Text fw={500} size="lg" c="gray">
                                Administrative
                            </Text>
                        </Group>

                        <Card shadow="xs" radius="sm" withBorder py={24} px={20}>
                            <Group gap={24} justify="space-between">
                                <Group>
                                    <IconFileTypePdf />
                                    <div>
                                        <Text size="md" fw="bold">
                                            Name of document.pdf
                                        </Text>
                                        <Text size="md" c="dimmed">
                                            11 Sep, 2023 - 13 MB
                                        </Text>
                                    </div>
                                </Group>
                                <IconDownload />
                            </Group>
                        </Card>

                        <Text fw={500} size="md">
                            Users in this approval process
                        </Text>

                        <Group>
                            <Avatar />
                            <div>
                                <Text size="md" fw={500}>
                                    John Doe
                                </Text>
                            </div>
                        </Group>

                        <Textarea
                            label="Comment"
                            placeholder="Add you comment on this document"
                            autosize
                            minRows={4}
                            maxRows={6}
                        />

                        <Flex align="center" justify="end">
                            <Button
                                color="red"
                                onClick={() => handleDocumentAction("rejected")}
                                loading={processing}
                            >
                                Reject
                            </Button>

                            <Button
                                ml={12}
                                color="green"
                                onClick={() => handleDocumentAction("approved")}
                                loading={processing}
                            >
                                Approve
                            </Button>
                        </Flex>
                    </Stack>
                </div>
            </Flex>
        </>
    );
};

export default ApproveDocumentPage;
