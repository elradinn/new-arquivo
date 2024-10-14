import ApproveIcon from "./ApproveIcon";
import { Avatar, Badge, Button, Card, Flex, Group, Stack, Text, Textarea } from "@mantine/core";
import { Head, useForm } from "@inertiajs/react";
import { IconDownload, IconFileTypePdf, IconFolder } from "@tabler/icons-react";
import { notifications } from "@mantine/notifications";
import { DocumentApprovalResourceData } from "@/Modules/DocumentApproval/Types/DocumentApprovalResourceData";
import StateBadge from "@/Modules/Common/Components/StateBadge/StateBadge";

const ApproveDocumentPage: React.FC<{ documentApproval: DocumentApprovalResourceData }> = ({ documentApproval }) => {
    // const { data, post, processing } = useForm({
    //     file_id: "",
    //     destination_id: "",
    //     notification_id: "",
    //     action: "",
    // });

    // const handleDocumentAction = (action: "approved" | "rejected") => {
    //     data.notification_id = notification.id;
    //     data.file_id = notification.data.file_id;
    //     data.destination_id = notification.data.move_to;
    //     data.action = action;

    //     post(route("approval.result"), {
    //         data: { ...data, action },
    //         onSuccess: () => {
    //             notifications.show({
    //                 message: `Document ${action} successfully`,
    //                 color: action === "approved" ? "green" : "red",
    //             });
    //         },
    //         onError: () => {
    //             notifications.show({
    //                 message: "Something went wrong",
    //                 color: "red",
    //             });
    //         },
    //     });
    // }
    return (
        <>
            <Head title="Approve Document" />
            <Flex mih={100} justify="center" mb={48} style={{ padding: '1rem' }}>
                <div style={{ maxWidth: '600px', width: '100%' }}>
                    <Stack gap={16} align="center" mb={16}>
                        <ApproveIcon />
                        <Text fw={500} size="xl" ta="center">
                            This document needs your {documentApproval.type} decision
                        </Text>
                    </Stack>

                    <Stack gap={24}>
                        {documentApproval.destination && (
                            <Group>
                                <IconFolder color="none" fill="gray" />
                                <Text fw={500} size="lg" c="gray">
                                    {documentApproval.destination || "No Destination"}
                                </Text>
                            </Group>
                        )}

                        <Card shadow="xs" radius="sm" withBorder py={24} px={20}>
                            <Group gap={24} justify="space-between">
                                <Group>
                                    <IconFileTypePdf />
                                    <div>
                                        <Text size="md" fw="bold">
                                            {documentApproval.document_name}
                                        </Text>
                                        <Text size="md" c="dimmed">
                                            {documentApproval.created_at} - <StateBadge state={documentApproval.overall_state} />
                                        </Text>
                                    </div>
                                </Group>
                                <IconDownload />
                            </Group>
                        </Card>

                        <Text fw={500} size="md">
                            Users in this approval process
                        </Text>

                        {documentApproval.document_user_approvals.map(userApproval => (
                            <Group key={userApproval.id}>
                                <Avatar />
                                <div>
                                    <Text size="md" fw={500}>
                                        {userApproval.user_name}
                                    </Text>

                                    <StateBadge state={userApproval.user_state} />
                                </div>
                            </Group>
                        ))}

                        <Textarea
                            label="Comment"
                            placeholder="Add your comment on this document"
                            autosize
                            minRows={4}
                            maxRows={6}
                            style={{ width: '100%' }}
                        />

                        <Flex align="center" justify="end">
                            <Button color="red">
                                Reject
                            </Button>

                            <Button ml={12} color="green">
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
